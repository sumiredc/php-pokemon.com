<?php

require_once app_path('Classes/Move.php');

// でんこうせっか
class MoveQuickAttack extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'でんこうせっか';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '先制攻撃。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeNormal';

    /**
    * 分類
    * @var string::physical:物理|special:特殊|status:変化
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
    public const PP = 30;

    /**
    * 優先度
    * @var integer
    */
    public const PRIORITY = 1;

    /**
    * 対象
    * @var string
    */
    public const TARGET = 'enemy';

}
