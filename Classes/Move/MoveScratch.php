<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// ひっかく
class MoveScratch extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'ひっかく';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '通常攻撃';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeNormal';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    public const SPECIES = 'physical';

    /**
    * 威力
    * @var integer
    */
    public const POWER = 40;

    /**
    * 命中率
    * @var integer
    */
    public const ACCURACY = 100;

    /**
    * 使用回数
    * @var integer
    */
    public const PP = 35;

    /**
    * 対象
    * @var string
    */
    public const TARGET = 'enemy';

}
