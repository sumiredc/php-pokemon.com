<?php
/**==================================================================
* お金（ネコにこばん）
==================================================================**/
trait ClassBattleStateMoneyTrait
{

    /**
    * 散らばったお金の取得
    * @return integer
    */
    public function getMoney(): int
    {
        return array_sum($this->money);
    }

    /**
    * お金のセット
    * @param integer
    * @return void
    */
    public function setMoney($money): void
    {
        $this->money[] = $money;
    }

    /**
    * お金の初期化
    * @param integer
    * @return void
    */
    public function initMoney(): void
    {
        $this->money[] = [];
    }
    
}
