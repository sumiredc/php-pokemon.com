<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// ハイドロポンプ
class MoveHydroPump extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'ハイドロポンプ';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '通常攻撃';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeWater';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    public const SPECIES = 'special';

    /**
    * 威力
    * @var integer
    */
    public const POWER = 110;

    /**
    * 命中率
    * @var integer
    */
    public const ACCURACY = 80;

    /**
    * 使用回数
    * @var integer
    */
    public const PP = 5;

    /**
    * 対象
    * @var string
    */
    public const TARGET = 'enemy';

}
