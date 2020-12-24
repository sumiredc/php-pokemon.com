<?php
/**==================================================================
* おこづかい
==================================================================**/
trait ClassPlayerMoneyTrait
{

    /**
    * おこづかい
    * @var integer
    */
    protected $money = 2000;

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
    * バトル敗北時のお小遣い消費
    * @return void
    */
    public function loseMoney(): void
    {
        // 半額を失う(切り捨て)
        $this->money = (int)($this->money / 2);
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
