<?php

// どうぐ
abstract class Item
{

    /**
    * @return void
    */
    public function __construct()
    {
        //
    }

    /**
    * 名称の取得
    * @return string
    */
    public function getName()
    {
        return $this->name;
    }

    /**
    * カテゴリの取得
    * @return string
    */
    public function getCategory()
    {
        return $this->category;
    }

    /**
    * 説明文の取得
    * @return string
    */
    public function getDescription()
    {
        return $this->description;
    }

    /**
    * 最大保有数の取得
    * @return integer|null
    */
    public function getMax()
    {
        return $this->max;
    }

    /**
    * 買値の取得
    * @return integer
    */
    public function getBidPrice()
    {
        return $this->bid_price;
    }

    /**
    * 売値の取得
    * @return integer
    */
    public function getSellPrice()
    {
        return $this->sell_price;
    }

    /**
    * 対象の取得
    * @return string
    */
    public function getTarget()
    {
        return $this->target;
    }

    /**
    * 使用タイミングの取得
    * @return array
    */
    public function getTiming(): array
    {
        return $this->timing;
    }

    /**
    * 性能値の取得
    * @return float
    */
    public function getPerformance()
    {
        return $this->performance ?? 0;
    }

    /**
    * 現在のページで使用できるかどうかの判定
    * @param page:string
    * @return boolean
    */
    public function allowUsed($page): bool
    {
        return in_array($page, $this->timing, true);
    }

    /**
    * 削除できるかどうかの判定
    * @return boolean
    */
    public function allowTrashed(): bool
    {
        // 最大所有数が設定されていれば削除可
        if(is_null($this->max)){
            return false;
        }
        return true;
    }

}
