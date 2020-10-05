<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// じわれ
class Fissure extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'じわれ';

    /**
    * 説明文
    * @var string
    */
    protected $description = '一撃必殺技';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'Ground';

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
    protected $accuracy = 30;

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

    /**
    * 一撃必殺技確認用フラグ
    * @var boolean
    */
    protected $one_hit_knockout_flg = true;

}
