<?php
// チェック関係格納トレイト
trait ServiceBattleCheckTrait
{

    /**
    * 技の使用可不可判定
    *
    * @param object $move Move
    * @param object $pokemon Pokemon
    * @return boolean (true: 使用可, false:使用不可(わるあがき))
    */
    protected function checkEnabledMove(object $move, object $pokemon)
    {
        $move_class = get_class($move);
        if($move_class === 'Struggle'){
            // わるあがき
            return false;
        }
        // ポケモンの技一覧
        $move_list = $pokemon->getMove(null, 'array');
        // 選択された技の添番を取得
        $num = array_search(
            $move_class,
            array_column($move_list, 'class'),
        );
        // PP残数の確認
        if($move_list[$num]['remaining'] > 0){
            // チャージターンは残PPそのまま
            if(!$this->checkChargeTurn($pokemon, $move)){
                // 残PPをマイナス1
                $pokemon->calRemainingPp('sub', 1, $num);
            }
            return true;
        }else{
            // 使用不可
            return false;
        }
    }

    /**
    * チャージターンかどうかの確認
    *
    * @param object $pokemon
    * @param object $move
    * @return boolean
    */
    protected function checkChargeTurn($pokemon, $move)
    {
        // チャージ技ではない
        if(!$move->getChargeFlg()){
            return false;
        }
        // 状態変化を取得
        $sc = $pokemon->getSc();
        // 現在未チャージ状態
        if(!isset($sc['ScCharge'])){
            // チャージターン
            return true;
        }
        // 残チャージターン数が1超過
        if($sc['ScCharge']['turn'] > 1){
            // チャージターン
            return true;
        }
        // チャージターンではない
        return false;
    }

    /**
    * アタック前の状態異常チェック
    *
    * @param object Pokemon
    * @return boolean
    */
    protected function checkBeforeSa($pokemon)
    {
        if(empty($pokemon->getSa())){
            // 状態異常にかかっていない
            return true;
        }
        switch ($pokemon->getSa()) {
            /**
            * まひ
            */
            case 'SaParalysis':
            // 1/4の確率で行動不能
            $paralysis = new SaParalysis;
            if(random_int(1, 4) === 1){
                $this->setMessage($paralysis->getFalseMessage($pokemon->getPrefixName()));
                return false;
            }
            break;
            /**
            * こおり
            */
            case 'SaFreeze':
            // 1/5の確率でこおり解除
            $freeze = new SaFreeze;
            if(random_int(1, 5) === 1){
                // こおり解除
                $pokemon->releaseSa();
                $this->setMessage($freeze->getRecoveryMessage($pokemon->getPrefixName()));
            }else{
                // 行動不可
                $this->setMessage($freeze->getFalseMessage($pokemon->getPrefixName()));
                return false;
            }
            break;
            /**
            * ねむり
            */
            case 'SaSleep':
            // ターンカウントが残っていれば行動不能
            $sleep = new SaSleep;
            // ターンカウントを進める
            $pokemon->goSaTurn();
            if($pokemon->getSa('turn') <= 0){
                // ねむり解除
                $pokemon->releaseSa();
                $this->setMessage($sleep->getRecoveryMessage($pokemon->getPrefixName()));
            }else{
                // 行動失敗
                $this->setMessage($sleep->getFalseMessage($pokemon->getPrefixName()));
                return false;
            }
            break;
            /**
            * ひんし
            */
            case 'SaFainting':
            return false;
            break;
        }
        return true;
    }

    /**
    * アタック前の状態変化チェック
    *
    * @param object Pokemon
    * @return boolean
    */
    protected function checkBeforeSc($pokemon)
    {
        $sc = $pokemon->getSc();
        if(empty($sc)){
            // 状態変化にかかっていない
            return true;
        }
        /**
        * ひるみ
        */
        if(isset($sc['ScFlinch'])){
            $flinch = new ScFlinch;
            // 行動失敗（ひるみ解除はcheckAfterScで行う）
            return false;
        }
        /**
        * こんらん
        */
        if(isset($sc['ScConfusion'])){
            $confusion = new ScConfusion;
            // こんらんのターンカウントを進める
            $pokemon->goScTurn('ScConfusion');
            if($sc['ScConfusion']['turn'] <= 0){
                // こんらん解除
                $pokemon->releaseSc('ScConfusion');
                $this->setMessage($confusion->getRecoveryMessage($pokemon->getPrefixName()));
            }else{
                // こんらんしている旨のメッセージ
                $this->setMessage($pokemon->getPrefixName().'は混乱している');
                // 1/3の確率で行動失敗
                if(!random_int(0, 2)){
                    // 行動失敗（自分に威力４０の物理ダメージ）
                    $this->setMessage($confusion->getFalseMessage($pokemon->getPrefixName()));
                    // ダメージ計算
                    $damage = $this->calDamage(
                        $pokemon->getLevel(),                   # レベル
                        $pokemon->getStats('Attack', true),     # 物理攻撃値（補正値込み）
                        $pokemon->getStats('Defense', true),    # 物理防御値（補正値込み）
                        40, # 技の威力
                        1,  # 補正値
                    );
                    // ダメージ計算
                    $pokemon->calRemainingHp('sub', $damage);
                    return false;
                }
            }
        }
        return true;
    }

    /**
    * アタック後の状態異常チェック
    *
    * @param object Pokemon
    * @return void
    */
    protected function checkAfterSa($pokemon)
    {
        if(empty($pokemon->getSa())){
            // 状態異常にかかっていない
            return;
        }
        switch ($pokemon->getSa()) {
            /**
            * どく
            */
            case 'SaPoison':
            // 最大HPの1/8ダメージを受ける
            $poison = new SaPoison;
            // 小数点以下切り捨て
            $damage = (int)($pokemon->getStats('HP') / 8);
            if($damage){
                // 最小ダメージ数は1
                $damage = 1;
            }
            // メッセージ
            $this->setMessage($poison->getTurnMessage($pokemon->getPrefixName()));
            break;
            /**
            * もうどく
            */
            case 'SaBadPoison':
            // 最大HPの(ターン数/16)ダメージを受ける（最大15/16）
            $bad_poison = new SaBadPoison;
            // ターンカウントを進める
            $pokemon->goSaTurn();
            // 小数点以下切り捨て
            $damage = (int)($pokemon->getStats('HP') / 16) * $pokemon->getSa('turn');
            if($damage){
                // 最小ダメージ数は1
                $damage = 1;
            }
            // メッセージ
            $this->setMessage($bad_poison->getTurnMessage($pokemon->getPrefixName()));
            break;
            /**
            * やけど
            */
            case 'SaBurn':
            // 最大HPの1/16ダメージを受ける
            $burn = new SaBurn;
            // 小数点以下切り捨て
            $damage = (int)($pokemon->getStats('HP') / 16);
            if($damage){
                // 最小ダメージ数は1
                $damage = 1;
            }
            // メッセージ
            $this->setMessage($burn->getTurnMessage($pokemon->getPrefixName()));
            break;
        }
        // ダメージ計算
        $pokemon->calRemainingHp('sub', $damage ?? 0);
    }

    /**
    * アタック後の状態変化チェック
    *
    * @param object Pokemon
    * @return void
    */
    protected function checkAfterSc($sicked_pokemon, $enemy_pokemon)
    {
        // ひるみ解除
        $sicked_pokemon->releaseSc('ScFlinch');
        // 状態変化を取得
        $sc = $sicked_pokemon->getSc();
        if(empty($sc)){
            // 状態異常にかかっていない
            return;
        }
        /**
        * やどりぎのタネ
        */
        if(isset($sc['ScLeechSeed'])){
            // 最大HPの1/8HPを吸収する
            $leech_seed = new ScLeechSeed;
            // 小数点以下切り捨て
            $damage = (int)($sicked_pokemon->getStats('HP') / 8);
            if($damage){
                // 最小ダメージ数は1
                $damage = 1;
            }
            // ダメージ計算
            $sicked_pokemon->calRemainingHp('sub', $damage);
            // 回復
            $enemy_pokemon->calRemainingHp('add', $damage);
            // メッセージ
            $this->setMessage($leech_seed->getTurnMessage($sicked_pokemon->getPrefixName()));
            // HPが０になっていればチェック終了
            if(!$sicked_pokemon->getRemainingHp()){
                return;
            }
        }
        /**
        * バインド
        */
        if(isset($sc['ScBind'])){
            // 最大HPの1/8ダメージを受ける
            $bind = new ScBind;
            // バインドのターンカウントを進める
            $sicked_pokemon->goScTurn('ScBind');
            if($sc['ScBind']['turn'] <= 0){
                // バインド解除
                $sicked_pokemon->releaseSc('ScBind');
                $this->setMessage($bind->getRecoveryMessage($sicked_pokemon->getPrefixName(), $sc['ScBind']['param']));
            }else{
                // 小数点以下切り捨て
                $damage = (int)($sicked_pokemon->getStats('HP') / 8);
                if($damage){
                    // 最小ダメージ数は1
                    $damage = 1;
                }
                // ダメージ計算
                $sicked_pokemon->calRemainingHp('sub', $damage);
                // メッセージ
                $this->setMessage($bind->getTurnMessage($sicked_pokemon->getPrefixName(), $sc['ScBind']['param']));
                // HPが０になっていればチェック終了
                if(!$sicked_pokemon->getRemainingHp()){
                    return;
                }
            }
        }
    }

    /**
    * ひんし判定
    *
    * @param object $pokemon
    * @return boolean
    */
    protected function checkFainting($pokemon)
    {
        if($pokemon->getSa() === 'SaFainting'){
            // ひんし状態
            $this->setMessage($pokemon->getMessages());
            // ポケモン内のメッセージを削除
            $pokemon->resetMessage();
            // ひんしポケモンの状態変化を全解除
            $pokemon->releaseSc();
            return true;
        }else{
            // ひんし状態ではない
            return false;
        }
    }

}
