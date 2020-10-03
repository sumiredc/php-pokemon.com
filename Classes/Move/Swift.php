<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// スピードスター
class Swift extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'スピードスター';

    /**
    * 説明文
    * @var string
    */
    protected $description = '必ず命中する。';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'Normal';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    protected $species = 'special';

    /**
    * 威力
    * @var integer
    */
    protected $power = 60;

    /**
    * 命中率
    * @var integer
    */
    protected $accuracy = null;

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
