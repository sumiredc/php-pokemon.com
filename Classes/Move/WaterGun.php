<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// みずでっぽう
class WaterGun extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'みずでっぽう';

    /**
    * 説明文
    * @var string
    */
    protected $description = '通常攻撃';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'Water';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    protected $species = 'special';

    /**
    * 威力
    * @var integer
    */
    protected $power = 40;

    /**
    * 命中率
    * @var integer
    */
    protected $accuracy = 100;

    /**
    * 使用回数
    * @var integer
    */
    protected $pp = 25;

    /**
    * 優先度
    * @var integer
    */
    protected $priority = 0;

}
