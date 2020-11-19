<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Item.php');

// モンスターボール
class ItemPokeBall extends Item
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'モンスターボール';

    /**
    * 説明文
    * @var string
    */
    protected $description = '野生のポケモンに投げて捕まえるためのボール。カプセル式になっている。';

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
    protected $bid_price = 200;

    /**
    * 売値
    * @var integer
    */
    protected $sell_price = 100;

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
    protected $performance = 1.0;

}
