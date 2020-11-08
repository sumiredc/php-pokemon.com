<?php
// 計算処理
trait ServiceBattleCalTrait
{

    /**
    * ダメージ計算（カッコ毎に小数点の切り捨てをする）
    * floor(floor(floor(レベル×2/5+2)×威力×A/D)/50+2)*M
    *
    * @param integer $l     レベル
    * @param integer $a     攻撃値
    * @param integer $d     防御値
    * @param integer $p     威力
    * @param integer $m     補正値
    * @return integer
    */
    private function calDamage(int $l, int $a, int $d, int $p, $m)
    {
        // 計算式を当てはめる
        $result = floor(floor(floor($l * 2 / 5 + 2) * $p * $a / $d) / 50 + 2) * $m;
        if($result === 0){
            // 計算結果が０になった場合は＋１
            $result++;
        }
        return $result;
    }

    /**************************************************************************
    * attack内で行う補正値の計算（補正値プロパティに直接格納）
    **************************************************************************/

    /**
    * タイプ相性チェック
    *
    * @param Type:object $atk_type
    * @param array $def_types
    * @return string
    */
    private function checkTypeCompatibility(object $atk_type, array $def_types)
    {
        // ダメージ補正(初期値は等倍)
        $m = 1;
        // 補正判定
        foreach($def_types as $def_type){
            // 「こうかがない」かチェック(わるあがきは除く)
            if(in_array($def_type, $atk_type->getAtkDoesntAffectTypes(), true)){
                // ダメージ無し
                $m = 0;
                // ループ終了
                break;
            }
            // 「こうかばつぐん」かチェック
            if(in_array($def_type, $atk_type->getAtkExcellentTypes(), true)){
                // 2倍
                $m *= 2;
                // 次の処理へスキップ
                continue;
            }
            // 「こうかいまひとつ」かチェック
            if(in_array($def_type, $atk_type->getAtkNotVeryTypes(), true)){
                // 半減
                $m /= 2;
            }
        }
        // 補正によるメッセージの分岐
        if($m > 1){
            // 等倍超過
            $message = 'こうかはばつぐんだ！';
        }
        if($m < 1){
            // 等倍未満
            $message = 'こうかはいまひとつだ';
        }
        // 算出した補正値を乗算
        $this->m *= $m;
        // メッセージを返却
        return $message ?? '';
    }

    /**
    * 壁補正判定
    *
    * @param Move:object $move
    * @param Pokemon:object $def
    * @return string
    */
    private function checkWall(object $move, object $def)
    {
        // ダメージ補正(初期値は等倍)
        $m = 1;
        // 技種類での分岐
        switch ($move->getSpecies()) {
            // 物理
            case 'physical':
            // 相手がリフレクター状態であれば半減
            if($this->battle_state->checkField($def->getPosition(), new FieldReflect)){
                $m = 0.5;
            }
            break;
            // 特殊
            case 'special':
            // 相手がひかりのかべ状態であれば半減
            if($this->battle_state->checkField($def->getPosition(), new FieldLightScreen)){
                $m = 0.5;
            }
            break;
        }
        // プロパティに算出結果を乗算
        $this->m *= $m;
    }

    /**************************************************************************
    * attackSuccess内で行う補正値の計算（補正値プロパティに直接格納しない）
    **************************************************************************/

    /**
    * 急所判定
    *
    * @param Move:object $move
    * @return mixed (numeric|boolean)
    */
    private function calCritical(...$rank)
    {
        switch (array_sum($rank)) {
            // 急所ランク＋０
            case 0:
            $chance = 4.17; #（％）
            break;
            // 急所ランク＋１
            case 1:
            $chance = 12.5; #（％）
            break;
            // 急所ランク＋２
            case 2:
            $chance = 50; #（％）
            break;
            // 急所ランク＋３以上
            default:
            $chance = 100; #（％）
            break;
        }
        /**
        * 0〜10000からランダムで数値を取得して、それより小さければ急所
        * 確率（$chance）は*100して整数で比較する
        */
        if(($chance * 100) >= (random_int(1, 10000))){
            // 急所に当たった
            return 1.5;
        }
        // 急所に当たらなかった
        return false;
    }

    /**
    * 乱数補正値の計算
    *
    * @return numeric
    */
    private function calRandNum()
    {
        // 85〜100の乱数をかけ、その後100で割る
        return random_int(85, 100) / 100;
    }

    /**
    * タイプ一致補正値の計算（一致→1.5倍）
    *
    * @param string $move_type 技タイプ
    * @param array $pokemon_types 攻撃ポケモンのタイプ
    * @return mixed (numeric|boolean)
    */
    private function calMatchType($move_type, $pokemon_types)
    {
        if(in_array($move_type, $pokemon_types, true)){
            // 攻撃ポケモンのタイプと技タイプが一致
            return 1.5;
        }
        // タイプ一致ではない
        return false;
    }

}
