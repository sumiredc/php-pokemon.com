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

}
