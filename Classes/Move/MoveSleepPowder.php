<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// ねむりごな
class MoveSleepPowder extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'ねむりごな';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '相手をねむり状態にする。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeGrass';

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
    public const ACCURACY = 75;

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

    /**
    * 追加効果
    *
    * @param args:array
    * @return array
    */
    public static function effects(...$args)
    {
        /**
        * @param atk:object::Pokemon 攻撃ポケモン
        * @param def:object::Pokemon 防御ポケモン
        */
        list($atk, $def) = $args;
        // 相手をねむり状態にする（2〜4ターン）
        return $def->setSa('SaSleep', random_int(2, 4));
    }

}
