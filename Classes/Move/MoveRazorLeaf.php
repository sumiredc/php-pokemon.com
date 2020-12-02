<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// はっぱカッター
class MoveRazorLeaf extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'はっぱカッター';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '急所に当たりやすい。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeGrass';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    public const SPECIES = 'physical';

    /**
    * 威力
    * @var integer
    */
    public const POWER = 55;

    /**
    * 命中率
    * @var integer
    */
    public const ACCURACY = 95;

    /**
    * 使用回数
    * @var integer
    */
    public const PP = 25;

    /**
    * 対象
    * @var string
    */
    public const TARGET = 'enemy';

    /**
    * 急所ランク
    * @var integer
    */
    public const CRITICAL = 1;

}
