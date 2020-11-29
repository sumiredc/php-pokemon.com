<?php
// 特別処理
trait ServiceBattleExTrait
{
    /**
    * オウムがえしの特別処理
    *
    * @param atk:object::Pokemon
    * @param def:object::Pokemon
    * @param move:object::Move
    * @return mixed::Move|false
    */
    protected function exMirrorMove(object $atk, object $def, object $move)
    {
        // チャージ・あばれる技の確認
        $wait_move = $this->exGetWaitingMove($atk);
        if(is_object($wait_move)){
            return $wait_move;
        }else{
            // 「オウムがえし」の発動メッセージ
            response()->setMessage($atk->getPrefixName().'は'.$move->getName().'を使った！');
            return $move->exMirrorMove($def, battle_state());
        }
    }

    /**
    * ゆびをふるの特別処理
    *
    * @param atk:object::Pokemon
    * @param move:object::Move
    * @return object::Move
    */
    protected function exMetronome(object $atk, object $move) :object
    {
        // チャージ・あばれる技の確認
        $wait_move = $this->exGetWaitingMove($atk);
        if(is_object($wait_move)){
            return $wait_move;
        }else{
            // 「ゆびをふる」の発動メッセージ
            response()->setMessage($atk->getPrefixName().'は'.$move->getName().'を使った！');
            return $move->exMetronome();
        }
    }

    /**
    * ネコにこばんの特別処理
    *
    * @param atk:object::Pokemon
    * @param move:object::Move
    * @return void
    */
    protected function exPayDay(object $atk, object $move): void
    {
        $move->exPayDay($atk, battle_state());
        response()->setMessage('辺りにお金が散らばった');
    }

    /**
    * へんしんの特別処理
    *
    * @param atk:object::Pokemon
    * @param def:object::Pokemon
    * @param move:object::Move
    * @return void
    */
    protected function exTransform(object $atk, object $def, object $move): void
    {
        // へんしんの特別処理を呼び出し
        $result = $move->exTransform($atk, $def, battle_state());
        if($result){
            // へんしん
            response()->setResponse([
                'param' => get_class($def),
                'action' => 'transform',
                'target' => $atk->getPosition(),
            ], $this->atk_msg_id);
            // 成功
            response()->setMessage($atk->getPrefixName().'は'.$def->getName().'にへんしんした');
            // プロパティの書き換え
            if($atk->getPosition() === 'friend'){
                // 味方
                battle_state()->setFriend(
                    battle_state()->getTransform('friend')
                );
                // $this->pokemon = $this->battle_state
                // ->getTransform('friend');
            }else if('enemy'){
                // 相手
                battle_state()->setEnemy(
                    battle_state()->getTransform('enemy')
                );
                // $this->enemy = $this->battle_state
                // ->getTransform('enemy');
            }
        }else{
            // 失敗
            response()->setMessage('しかし上手く決まらなかった');
        }
    }

    /**
    * 特別処理時の待機技（チャージorあばれる）の取得
    *
    * @param atk:object::Pokemon
    * @return mixed::Move|false
    */
    protected function exGetWaitingMove(object $atk)
    {
        //「チャージ状態」になっているかどうかを確認
        $charge = $atk->getChargeMove();
        if($charge){
            return new $charge;
        }
        //「あばれる状態」になっているかどうかを確認
        $thrash = $atk->getThrashMove();
        if($thrash){
            return new $thrash;
        }
        return false;
    }

}
