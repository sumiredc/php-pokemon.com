<?php
trait ServiceBattleAttackTrait
{
    /**
    * 省略記号
    *
    * @var L レベル
    * @var A 攻撃値
    * @var D 防御値
    * @var P 威力
    * @var M 補正値
    */

    /**
    * 補正値
    * @var float 小数点第2位までの数値
    */
    private $m = 1;

    /**
    * 攻撃
    * （攻撃→ダメージ計算→ひんし判定）
    *
    * @param object $atk_pokemon
    * @param object $def_pokemon
    * @param object $move
    * @return void
    */
    protected function attack($atk_pokemon, $def_pokemon, $move)
    {
        // 行動チェック(状態異常・状態変化)
        if(!$this->checkBeforeSa($atk_pokemon) || !$this->checkBeforeSc($atk_pokemon)){
            // 行動失敗
            return;
        }
        // わざの使用可不可判定
        if(!$this->checkEnabledMove($move, $atk_pokemon)){
            $this->setMessage($atk_pokemon->getPrefixName().'は出すことのできる技がない');
            // わるあがきをセット
            $move = new Struggle;
        }
        // チャージチェック
        if($move->charge($atk_pokemon)){
            // チャージターンならメッセージを格納して行動終了
            $this->setMessage($atk_pokemon->getMessages());
            $atk_pokemon->resetMessage();
            return;
        }
        // 攻撃メッセージを格納
        $this->setMessage($atk_pokemon->getPrefixName().'は'.$move->getName().'を使った！');
        // タイプ相性チェック
        $type_comp_msg = $this->checkTypeCompatibility($move->getType(), $def_pokemon->getTypes());
        // 「こうかがない」の判定（命中率と威力がnullではなく、タイプ相性補正が０の場合）
        if(!is_null($move->getAccuracy()) && !is_null($move->getPower()) && ($this->m === 0)){
            // こうかがない
            $this->setMessage($def_pokemon->getPrefixName().'には効果が無いみたいだ');
            return;
        }
        // 命中判定
        $hit = $this->checkHit($move->getAccuracy());
        if(!$hit){
            // 攻撃失敗
            $this->setMessage('しかし攻撃は外れた！');
            return;
        }
        // 必要ステータスの取得
        $stats = $this->getStats($move->getSpecies(), $atk_pokemon, $def_pokemon);
        // ダメージ計算
        if($move->getSpecies() !== 'status'){
            /**
            * 物理,特殊技
            */
            if(!is_null($move->getPower())){
                // 急所判定（固定ダメージ技は判定不要）
                $critical = $this->checkCritical($move->getCritical());
                if($critical){
                    $this->setMessage('急所に当たった！');
                }
            }
            // 乱数補正値の計算
            $this->calRandNum();
            // タイプ一致補正の計算
            $this->calMatchType($move->getType(), $atk_pokemon->getTypes());
            // ダメージ計算
            $damage = $this->calDamage(
                $atk_pokemon->getLevel(),   # 攻撃ポケモンのレベル
                $stats['a'],                # 攻撃ポケモンの攻撃値
                $stats['d'],                # 防御ポケモンの防御値
                $move->getPower(),          # 技の威力
                $this->m,                   # 補正値
            );
            // やけど補正
            if(($move->getSpecies() === 'physical') && ($atk_pokemon->getSa() === 'SaBurn')){
                // 物理且つやけど状態ならダメージを半減
                $damage *= 0.5;
            }
            // タイプ相性のメッセージを返却
            $this->setMessage($type_comp_msg);
        }else{
            /**
            * 変化技
            */
            $damage = 0;
        }
        // ダメージ計算
        $def_pokemon->calRemainingHp('sub', $damage);
        // 追加効果(相手にHPが残っていれば)
        if($def_pokemon->getRemainingHp()){
            // 追加効果
            $move->effects($atk_pokemon, $def_pokemon);
            // 追加効果のメッセージをセット
            $this->setMessage($move->getMessages());
            $move->resetMessage();
            return;
        }
    }

    /**
    * 命中判定
    *
    * @param integer|null
    * @return boolean
    */
    private function checkHit($accuracy)
    {
        // nullの場合は命中率関係無し
        if(is_null($accuracy)){
            return true;
        }
        /**
        * 0〜100からランダムで数値を取得して、それより小さければ命中
        * 例：命中80%→mt_randで60が生成されたら成功、90なら失敗
        */
        if($accuracy >= mt_rand(0, 100)){
            return true;
        }
        return false;
    }

    /**
    * ステータス（攻撃値、防御値）の取得
    *
    * @param string $species
    * @param object $atk_pokemon
    * @param object $def_pokemon
    * @return array
    */
    private function getStats($species, $atk_pokemon, $def_pokemon)
    {
        // 技種類での分岐
        switch ($species) {
            // 物理
            case 'physical':
            $a = $atk_pokemon->getStats('Attack', true);
            $d = $def_pokemon->getStats('Defense', true);
            break;
            // 特殊
            case 'special':
            $a = $atk_pokemon->getStats('SpAtk', true);
            $d = $def_pokemon->getStats('SpDef', true);
            break;
            // 変化
            case 'status':
            // ここに変化技の処理
            break;
        }
        // 配列にして返却
        return [
            'a' => $a ?? 0,
            'd' => $d ?? 0,
        ];
    }

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

    /****************************************************************
    * 補正値の計算
    ****************************************************************/

    /**
    * タイプ相性チェック
    *
    * @param object $atk_type
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
    * 急所判定
    *
    * @param object $move
    * @return void
    */
    private function checkCritical(...$rank)
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
        if(($chance * 100) >= (mt_rand(0, 10000))){
            // 急所に当たった
            $this->m *= 1.5;
            return true;
        }
        // 急所に当たらなかった
        return false;
    }

    /**
    * 乱数補正値の計算
    *
    * @return void
    */
    private function calRandNum()
    {
        // 85〜100の乱数をかけ、その後100で割る
        $this->m *= (mt_rand(85, 100) / 100);
    }

    /**
    * タイプ一致補正値の計算（一致→1.5倍）
    *
    * @param string $move_type 技タイプ
    * @param array $pokemon_types 攻撃ポケモンのタイプ
    * @return void
    */
    private function calMatchType($move_type, $pokemon_types)
    {
        if(in_array($move_type, $pokemon_types, true)){
            // 攻撃ポケモンのタイプと技タイプが一致
            $this->m *= 1.5;
        }
    }

}
