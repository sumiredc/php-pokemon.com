<?php
require_once(__DIR__.'/../Move.php');

// ソーラービーム
class SolarBeam extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'ソーラービーム';

    /**
    * 説明文
    * @var string
    */
    protected $description = '1ターン目に溜め、2ターン目で攻撃する。';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'Grass';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    protected $species = 'special';

    /**
    * 威力
    * @var integer
    */
    protected $power = 120;

    /**
    * 命中率
    * @var integer
    */
    protected $accuracy = 100;

    /**
    * 使用回数
    * @var integer
    */
    protected $pp = 10;

    /**
    * 優先度
    * @var integer
    */
    protected $priority = 0;

}
