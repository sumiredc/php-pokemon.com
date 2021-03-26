<?php
require_once app_path('Classes/Item.php');

/**
* モンスターボール
*/
class ItemPokeBall extends Item
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'モンスターボール';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '野生のポケモンに投げて捕まえるためのボール。カプセル式になっている。';

    /**
    * カテゴリ
    * @var string::general|health|ball|important|machine
    */
    public const CATEGORY = 'ball';

    /**
    * 最大所有数
    * @var integer
    */
    public const MAX = 99;

    /**
    * 買値
    * @var integer
    */
    public const BID_PRICE = 200;

    /**
    * 売値
    * @var integer
    */
    public const SELL_PRICE = 100;

    /**
    * 対象
    * @var string::friend|player|enemy
    */
    public const TARGET = 'enemy';

    /**
    * 使用できるタイミング
    * @var array
    */
    public const TIMING = ['battle'];

    /**
    * 捕獲補正率
    * @var float
    */
    public const PERFORMANCE = 1.0;

}
