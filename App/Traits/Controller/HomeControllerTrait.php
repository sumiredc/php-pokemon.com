<?php

/**
 * ホームコントローラー用トレイト
 */
trait HomeControllerTrait
{

    /**
    * 引き継ぎ処理
    * @return void
    */
    protected function takeOver()
    {
        // パーティーにセット
        $this->party = $this->unserializeObject($_SESSION['__data']['party']);
    }

    /**
    * 戦闘に参加するポケモン番号を取得
    *
    * @return integer
    */
    protected function getFightPokemonOrder()
    {
        $orders = array_filter($this->party, function($partner){
            return $partner->getRemainingHp() > 0;
        });
        if(empty($orders)){
            return null;
        }else{
            return array_key_first($orders);
        }
    }

}
