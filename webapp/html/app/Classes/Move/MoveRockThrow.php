<?php

require_once app_path('Classes/Move.php');

// いわおとし
class MoveRockThrow extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'いわおとし';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '通常攻撃。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeRock';

    /**
    * 分類
    * @var string::physical:物理|special:特殊|status:変化
    */
    public const SPECIES = 'physical';

    /**
    * 威力
    * @var integer
    */
    public const POWER = 50;

    /**
    * 命中率
    * @var integer
    */
    public const ACCURACY = 90;

    /**
    * 使用回数
    * @var integer
    */
    public const PP = 15;

    /**
    * 対象
    * @var string
    */
    public const TARGET = 'enemy';

}
