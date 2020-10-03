<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// ハイドロポンプ
class HydroPump extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'ハイドロポンプ';

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
    protected $power = 110;

    /**
    * 命中率
    * @var integer
    */
    protected $accuracy = 80;

    /**
    * 使用回数
    * @var integer
    */
    protected $pp = 5;

    /**
    * 優先度
    * @var integer
    */
    protected $priority = 0;

}
