<?php
// 特別処理
trait ServiceBattleExTrait
{
    /**
    * オウムがえしの特別処理
    *
    * @param atk:object::Pokemon
    * @param def:object::Pokemon
    * @param move:string
    * @return mixed::string|false
    */
    protected function exMirrorMove(object $atk, object $def, string $move)
    {
        // チャージ・あばれる技の確認
        $wait_move = $this->exGetWaitingMove($atk);
        if($wait_move){
            return $wait_move;
        }else{
            // 「オウムがえし」の発動メッセージ
            response()->setMessage($atk->getPrefixName().'は'.$move::NAME.'を使った！');
            return $move::exMirrorMove($def, battle_state());
        }
    }

    /**
    * ゆびをふるの特別処理
    *
    * @param atk:object::Pokemon
    * @param move:string
    * @return string
    */
    protected function exMetronome(object $atk, string $move): string
    {
        // チャージ・あばれる技の確認
        $wait_move = $this->exGetWaitingMove($atk);
        if($wait_move){
            return $wait_move;
        }else{
            // 「ゆびをふる」の発動メッセージ
            response()->setMessage($atk->getPrefixName().'は'.$move::NAME.'を使った！');
            return $move::exMetronome();
        }
    }

    /**
    * ネコにこばんの特別処理
    *
    * @param atk:object::Pokemon
    * @param move:string
    * @return void
    */
    protected function exPayDay(object $atk, string $move): void
    {
        battle_state()->setMoney($move::exPayDay($atk));
        response()->setMessage('辺りにお金が散らばった');
    }

    /**
    * へんしんの特別処理
    *
    * @param atk:object::Pokemon
    * @param def:object::Pokemon
    * @param move:string
    * @return void
    */
    protected function exTransform(object $atk, object $def, string $move): void
    {
        // へんしんの特別処理を呼び出し
        if($move::exTransform($atk, $def)){
            // へんしん
            response()->setResponse([
                'param' => get_class($def),
                'action' => 'transform',
                'target' => $atk->getPosition(),
            ], $this->atk_msg_id);
            // 成功
            response()->setMessage($atk->getPrefixName().'は'.$def::NAME.'にへんしんした');
        }else{
            // 失敗
            response()->setMessage('しかし上手く決まらなかった');
        }
    }

    /**
    * 特別処理時の待機技（チャージorあばれる）の取得
    * @param atk:object::Pokemon
    * @return mixed::string|false
    */
    protected function exGetWaitingMove(object $atk)
    {
        //「チャージ状態」になっているかどうかを確認
        $charge = $atk->getChargeMove();
        if($charge){
            return $charge;
        }
        //「あばれる状態」になっているかどうかを確認
        $thrash = $atk->getThrashMove();
        if($thrash){
            return $thrash;
        }
        return false;
    }

}
