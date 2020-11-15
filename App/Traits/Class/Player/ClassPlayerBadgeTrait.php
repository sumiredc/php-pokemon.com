<?php
trait ClassPlayerBadgeTrait
{
    /**==================================================================
    * ジムバッジ
    ==================================================================**/
    /**
    * ジムバッジの確認
    * @param key:string
    * @return boolean
    */
    public function isBadge(string $key) :bool
    {
        return $this->badges[$key];
    }

    /**
    * ジムバッジの全取得
    * @return array
    */
    public function getBadges() :array
    {
        return $this->badges;
    }

    /**
    * ジムバッジの取得
    * @param key:string
    * @return void
    */
    public function setBadge(string $key) :void
    {
        $this->badges[$key] = true;
    }
    
}
