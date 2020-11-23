<?php
// チェック関係格納トレイト
trait ServiceBattleCheckTrait
{

    /**
    * 技の使用可不可判定
    *
    * @param move:object::Move
    * @param pokemon:object::Pokemon
    * @return boolean (true: 使用可, false:使用不可(わるあがき))
    */
    protected function checkEnabledMove(object $move, object $pokemon)
    {
        $move_class = get_class($move);
        if($move_class === 'MoveStruggle'){
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
        // チャージターンかつあばれる状態でなければPP減少
        if(
            !$this->checkChargeTurn($pokemon, $move) &&
            !$pokemon->checkSc('ScThrash')
        ){
            // 残PPをマイナス1
            $pokemon->calRemainingPp('sub', 1, $num);
        }
        return true;
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
        // 現在未チャージ状態
        if(!$pokemon->checkSc('ScCharge')){
            // チャージターン
            return true;
        }
        // 残チャージターン数が1超過
        if($pokemon->getSc('ScCharge', true) > 1){
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
            if(!random_int(0, 3)){
                setMessage(
                    $paralysis->getFailedMessage($pokemon->getPrefixName())
                );
                return false;
            }
            break;
            /**
            * こおり
            */
            case 'SaFreeze':
            // 1/5の確率でこおり解除
            $freeze = new SaFreeze;
            if(!random_int(0, 4)){
                // こおり解除
                $pokemon->releaseSa();
                setMessage(
                    $freeze->getRecoveryMessage($pokemon->getPrefixName())
                );
            }else{
                // 行動不可
                setMessage(
                    $freeze->getFailedMessage($pokemon->getPrefixName())
                );
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
            if(empty($pokemon->getSa())){
                // ねむり解除
                $msg_id = issueMsgId();
                setMessage(
                    $sleep->getRecoveryMessage($pokemon->getPrefixName()), $msg_id
                );
                setResponse([
                    'action' => 'sa-release',
                    'target' => $pokemon->getPosition()
                ], $msg_id);
            }else{
                // 行動失敗
                setMessage(
                    $sleep->getFailedMessage($pokemon->getPrefixName())
                );
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
    * 1. ひるみ
    * 2. 反動
    * 3. こんらん
    * @param object Pokemon
    * @return boolean
    */
    protected function checkBeforeSc($pokemon)
    {
        // 状態変化の値を取得
        if(empty($pokemon->getSc())){
            // 状態変化にかかっていない
            return true;
        }
        /**
        * ひるみ
        */
        if($pokemon->checkSc('ScFlinch')){
            // 行動失敗（ひるみ解除はcheckAfterScで行う※先手はひるみの影響を受けないため）
            return false;
        }
        /**
        * 反動
        */
        if($pokemon->checkSc('ScRecoil')){
            $recoil = new ScRecoil;
            // 反動メッセージを格納
            setMessage(
                $recoil->getFailedMessage($pokemon->getPrefixName())
            );
            // 反動解除
            $pokemon->releaseSc('ScRecoil');
            return false;
        }
        /**
        * こんらん
        */
        if($pokemon->checkSc('ScConfusion')){
            $confusion = new ScConfusion;
            // こんらんのターンカウントを進める
            $pokemon->goScTurn('ScConfusion');
            if(!$pokemon->checkSc('ScConfusion')){
                // こんらん解除
                setMessage(
                    $confusion->getRecoveryMessage($pokemon->getPrefixName())
                );
            }else{
                // こんらんしている旨のメッセージ
                setMessage(
                    $pokemon->getPrefixName().'は混乱している'
                );
                // 1/3の確率で行動失敗
                if(!random_int(0, 2)){
                    // メッセージIDの生成
                    $msg_id = issueMsgId();
                    // 行動失敗（自分に威力４０の物理ダメージ）
                    setMessage(
                        $confusion->getFailedMessage($pokemon->getPrefixName()),
                        $msg_id
                     );
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
                    // HPバーのアニメーション用レスポンス
                    setResponse([
                        'param' => $damage,
                        'action' => 'hpbar',
                        'target' => $pokemon->getPosition(),
                    ], $msg_id);
                    // 行動失敗
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
        // メッセージIDの生成
        $msg_id = issueMsgId();
        // 状態異常に合わせた分岐
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
            setAutoMessage($msg_id); # アニメーション用
            setMessage(
                $poison->getTurnMessage($pokemon->getPrefixName())
            );
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
            setAutoMessage($msg_id); # アニメーション用
            setMessage(
                $bad_poison->getTurnMessage($pokemon->getPrefixName())
            );
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
            setAutoMessage($msg_id); # アニメーション用
            setMessage(
                $burn->getTurnMessage($pokemon->getPrefixName())
            );
            break;
        }
        // ダメージ判定
        if(isset($damage)){
            $pokemon->calRemainingHp('sub', $damage);
            // HPバーのアニメーション用レスポンス
            setResponse([
                'param' => $damage,
                'action' => 'hpbar',
                'target' => $pokemon->getPosition(),
            ], $msg_id);
        }
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
        // 状態異常にかかっていない
        if(empty($sicked_pokemon->getSc())){
            return;
        }
        /**
        * やどりぎのタネ
        */
        if($sicked_pokemon->checkSc('ScLeechSeed')){
            // メッセージIDの生成(ダメージ用と回復用)
            $ls_msg_id1 = issueMsgId();
            $ls_msg_id2 = issueMsgId();
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
            // HPバーのアニメーション用レスポンス
            setResponse([
                'param' => $damage,
                'action' => 'hpbar',
                'target' => $sicked_pokemon->getPosition(),
            ], $ls_msg_id1);
            // 回復
            $enemy_pokemon->calRemainingHp('add', $damage);
            // HPバーのアニメーション用レスポンス
            setResponse([
                'param' => $damage * -1, # 加算するため負の数に変換してセット
                'action' => 'hpbar',
                'target' => $enemy_pokemon->getPosition(),
            ], $ls_msg_id2);
            // メッセージ（アニメーション用に空メッセージを2つ用意）
            setAutoMessage($ls_msg_id1);
            setAutoMessage($ls_msg_id2);
            setMessage(
                $leech_seed->getTurnMessage($sicked_pokemon->getPrefixName())
            );
            // HPが０になっていればチェック終了
            if(!$sicked_pokemon->getRemainingHp()){
                return;
            }
        }
        /**
        * バインド
        */
        if($sicked_pokemon->checkSc('ScBind')){
            // 最大HPの1/8ダメージを受ける
            $bind = new ScBind;
            // バインドのターンカウントを進める
            $sicked_pokemon->goScTurn('ScBind');
            if(!$sicked_pokemon->checkSc('ScBind')){
                // バインド解除
                setMessage($bind->getRecoveryMessage(
                    $sicked_pokemon->getPrefixName(),
                    $sicked_pokemon->getSc('ScBind', false, true)
                    )
                );
            }else{
                // メッセージIDの生成
                $b_msg_id = issueMsgId();
                // 小数点以下切り捨て
                $damage = (int)($sicked_pokemon->getStats('HP') / 8);
                if($damage){
                    // 最小ダメージ数は1
                    $damage = 1;
                }
                // ダメージ計算
                $sicked_pokemon->calRemainingHp('sub', $damage);
                // HPバーのアニメーション用レスポンス
                setResponse([
                    'param' => $damage,
                    'action' => 'hpbar',
                    'target' => $sicked_pokemon->getPosition(),
                ], $b_msg_id);
                // メッセージ
                setAutoMessage($b_msg_id);
                setMessage($bind->getTurnMessage(
                    $sicked_pokemon->getPrefixName(),
                    $sicked_pokemon->getSc('ScBind', false, true)
                    )
                );
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
            // ひんしポケモンの状態変化を全解除
            $pokemon->releaseSc();
            return true;
        }else{
            // ひんし状態ではない
            return false;
        }
    }

}
