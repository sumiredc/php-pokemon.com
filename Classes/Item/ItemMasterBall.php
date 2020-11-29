<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Item.php');

// マスターボール
class ItemMasterBall extends Item
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'マスターボール';

    /**
    * 説明文
    * @var string
    */
    protected $description = '野生のポケモンを、必ず捕まえることができる最高性能のボール。';

    /**
    * カテゴリ
    * @var string::general|health|ball|important|machine
    */
    protected $category = 'ball';

    /**
    * 最大所有数
    * @var integer
    */
    protected $max = 99;

    /**
    * 買値
    * @var integer
    */
    protected $bid_price = null;

    /**
    * 売値
    * @var integer
    */
    protected $sell_price = null;

    /**
    * 対象
    * @var string::friend|player|enemy
    */
    protected $target = 'enemy';

    /**
    * 使用できるタイミング
    * @var array
    */
    protected $timing = ['battle'];

    /**
    * 捕獲補正率
    * @var float
    */
    protected $performance = null;

}
