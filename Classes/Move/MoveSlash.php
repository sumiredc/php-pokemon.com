<?php

require_once(root_path('Classes').'Move.php');

// きりさく
class MoveSlash extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'きりさく';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '急所に当たりやすい。';

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
    public const POWER = 70;

    /**
    * 命中率
    * @var integer
    */
    public const ACCURACY = 100;

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

    /**
    * 急所ランク
    * @var integer
    */
    public const CRITICAL = 1;

}
