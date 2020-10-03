<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// いかり
class Rage extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'いかり';

    /**
    * 説明文
    * @var string
    */
    protected $description = 'いかり状態になり、ダメージを受けるたびにこうげきが1段階上がる。';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'Normal';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    protected $species = 'physical';

    /**
    * 威力
    * @var integer
    */
    protected $power = 20;

    /**
    * 命中率
    * @var integer
    */
    protected $accuracy = 100;

    /**
    * 使用回数
    * @var integer
    */
    protected $pp = 20;

    /**
    * 優先度
    * @var integer
    */
    protected $priority = 0;

}
