<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// しろいきり
class MoveMist extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'しろいきり';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '5ターンの間、場をしろいきり状態にして能力を下げられなくする。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeIce';

    /**
    * 分類
    * @var string::physical:物理|special:特殊|status:変化
    */
    public const SPECIES = 'status';

    /**
    * 威力
    * @var integer
    */
    public const POWER = null;

    /**
    * 命中率
    * @var integer
    */
    public const ACCURACY = null;

    /**
    * 使用回数
    * @var integer
    */
    public const PP = 30;

    /**
    * 対象
    * @var string
    */
    public const TARGET = 'friend';

    /**
    * フィールド効果
    * @var array
    */
    public static $field = [
        'class' => 'FieldMist',
        'turn' => 5,
    ];

}
