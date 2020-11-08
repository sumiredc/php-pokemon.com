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
            setMessage($atk->getPrefixName().'は'.$move->getName().'を使った！');
            return $move->exMirrorMove($def, $this->battle_state);
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
            setMessage($atk->getPrefixName().'は'.$move->getName().'を使った！');
            return $move->exMetronome();
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
