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
    private $m;

    /**
    * タイプ相性メッセージ
    * @var string
    */
    private $type_comp_msg = '';

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
        // 補正値の初期化
        $this->m = 1;
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
        $this->type_comp_msg = $this->checkTypeCompatibility($move->getType(), $def_pokemon->getTypes());
        // 「こうかがない」の判定（命中率と威力がnullではなく、タイプ相性補正が０の場合）
        if(!is_null($move->getAccuracy()) && !is_null($move->getPower()) && ($this->m === 0)){
            // こうかがない
            $this->setMessage($def_pokemon->getPrefixName().'には効果が無いみたいだ');
            // 失敗判定
            $this->attackFailed($atk_pokemon, $move);
            return;
        }
        // 命中判定
        if(!$this->checkHit($atk_pokemon, $def_pokemon, $move)){
            // 攻撃失敗
            $this->attackFailed($atk_pokemon, $move);
            return;
        }
        // 一撃必殺
        if($move->getOneHitKnockoutFlg()){
            $def_pokemon->calRemainingHp('death');
            $this->setMessage('一撃必殺');
            return;
        }
        // 技を回数分実行
        $times = $move->times();
        for($i = 0; $i < $times; $i++){
            // 攻撃判定成功時の処理
            $this->attackSuccess($atk_pokemon, $def_pokemon, $move);
        }
        // 連続技はヒット回数のメッセージを返却
        if($times > 1){
            return $this->setMessage($times.'回当たった');
        }
    }

    /**
    * 攻撃判定失敗時の処理
    *
    * @param object Pokemon $atk
    * @param object Move $move
    * @return void
    */
    private function attackFailed($atk, $move)
    {
        // 技の失敗メソッドを呼び出し
        $move->failed($atk);
        // もしメッセージが返ってきていれば格納
        if(!empty($move->getMessages())){
            $this->setMessage($move->getMessages());
            $move->resetMessage();
        }
    }

    /**
    * 攻撃判定成功時の処理
    *
    * @param object $atk_pokemon
    * @param object $def_pokemon
    * @param object $move
    * @return void
    */
    private function attackSuccess($atk_pokemon, $def_pokemon, $move)
    {
        // ローカル変数として補正値を用意
        $m = 1;
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
                    // 補正値を乗算
                    $m *= $critical;
                    $this->setMessage('急所に当たった！');
                }
            }
            // 乱数補正値の計算
            $rand = $this->calRandNum();
            if($rand){
                // 補正値を乗算
                $m *= $rand;
            }
            // タイプ一致補正の計算
            $this->calMatchType($move->getType(), $atk_pokemon->getTypes());
            // ダメージ計算
            $damage = $this->calDamage(
                $atk_pokemon->getLevel(),   # 攻撃ポケモンのレベル
                $stats['a'],                # 攻撃ポケモンの攻撃値
                $stats['d'],                # 防御ポケモンの防御値
                $move->getPower(),          # 技の威力
                $this->m * $m,              # 補正値(プロパティ*ローカル)
            );
            // やけど補正
            if(($move->getSpecies() === 'physical') && ($atk_pokemon->getSa() === 'SaBurn')){
                // 物理且つやけど状態ならダメージを半減
                $damage *= 0.5;
            }
            // タイプ相性のメッセージを返却
            $this->setMessage($this->type_comp_msg);
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
    * @param object $atk
    * @param object $def
    * @param object $move
    * @return boolean
    */
    private function checkHit($atk, $def, $move)
    {
        // 一撃必殺技のチェック
        if($move->getOneHitKnockoutFlg()){
            if($atk->getLevel() < $def->getLevel()){
                // 相手の方がレベルが高ければ無効
                $this->setMessage($move->getOneHitKnockoutFailedMessage($def->getPrefixName()));
                return false;
            }
            // レベル差計算を含めた命中率を取得
            $accuracy = $move->getOneHitKnockoutAccuracy($atk, $def);

        }else{
            // 命中率取得
            $accuracy = $move->getAccuracy();
        }
        // nullの場合は命中率関係無し
        if(is_null($accuracy)){
            return true;
        }
        /**
        * 0〜100からランダムで数値を取得して、それより小さければ命中
        * 例：命中80%→mt_randで60が生成されたら成功、90なら失敗
        */
        if($accuracy >= mt_rand(0, 100)){
            // 攻撃成功
            return true;
        }
        // 攻撃失敗
        $this->setMessage($move->getFailedMessage($atk->getPrefixName()));
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

    /**************************************************************************
    * attack内で行う補正値の計算（補正値プロパティに直接格納）
    **************************************************************************/

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

    /**************************************************************************
    * attackSuccess内で行う補正値の計算（補正値プロパティに直接格納しない）
    **************************************************************************/

    /**
    * 急所判定
    *
    * @param object $move
    * @return mixed (numeric|boolean)
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
        return (mt_rand(85, 100) / 100);
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
