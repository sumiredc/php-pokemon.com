<?php
/**==================================================================
* おこづかい
==================================================================**/
trait ClassPlayerMoneyTrait
{

    /**
    * おこづかいの増加
    * @param money:integer
    * @return void
    */
    public function addMoney($money): void
    {
        $this->money += $money;
    }

    /**
    * おこづかいの消費
    * @param money:integer
    * @return void
    */
    public function subMoney($money): void
    {
        $this->money -= $money;
    }

    /**
    * おこづかいの取得
    * @return integer
    */
    public function getMoney() :int
    {
        return $this->money;
    }

}
