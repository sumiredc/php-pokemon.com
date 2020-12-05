<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// スピードスター
class MoveSwift extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'スピードスター';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '必ず命中する。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeNormal';

    /**
    * 分類
    * @var string::physical:物理|special:特殊|status:変化
    */
    public const SPECIES = 'special';

    /**
    * 威力
    * @var integer
    */
    public const POWER = 60;

    /**
    * 命中率
    * @var integer
    */
    public const ACCURACY = null;

    /**
    * 使用回数
    * @var integer
    */
    public const PP = 20;

    /**
    * 対象
    * @var string
    */
    public const TARGET = 'enemy';

}
