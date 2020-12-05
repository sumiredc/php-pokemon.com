<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// ひかりのかべ
class MoveLightScreen extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'ひかりのかべ';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '5ターンの間、相手の特殊技のダメージが半分になる。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypePsychic';

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
        'class' => 'FieldLightScreen',
        'turn' => 5,
    ];

}
