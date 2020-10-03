<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// はっぱカッター
class RazorLeaf extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'はっぱカッター';

    /**
    * 説明文
    * @var string
    */
    protected $description = '急所に当たりやすい。';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'Grass';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    protected $species = 'physical';

    /**
    * 威力
    * @var integer
    */
    protected $power = 55;

    /**
    * 命中率
    * @var integer
    */
    protected $accuracy = 95;

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

    /**
    * 急所ランク
    * @var integer
    */
    protected $critical = 1;

}
