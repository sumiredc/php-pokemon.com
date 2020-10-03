<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// でんこうせっか
class QuickAttack extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'でんこうせっか';

    /**
    * 説明文
    * @var string
    */
    protected $description = '先制攻撃。';

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
    protected $power = null;

    /**
    * 命中率
    * @var integer
    */
    protected $accuracy = 100;

    /**
    * 使用回数
    * @var integer
    */
    protected $pp = 30;

    /**
    * 優先度
    * @var integer
    */
    protected $priority = 1;



}
