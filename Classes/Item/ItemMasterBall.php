<?php
require_once(root_path('Classes').'Item.php');

/**
* マスターボール
*/
class ItemMasterBall extends Item
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'マスターボール';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '野生のポケモンを、必ず捕まえることができる最高性能のボール。';

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
    public const BID_PRICE = null;

    /**
    * 売値
    * @var integer
    */
    public const SELL_PRICE = null;

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
    public const PERFORMANCE = null;

}
