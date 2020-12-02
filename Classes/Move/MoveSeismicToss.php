<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// ちきゅうなげ
class MoveSeismicToss extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'ちきゅうなげ';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '自分のレベル分の固定ダメージを与える';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeFighting';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    public const SPECIES = 'physical';

    /**
    * 威力
    * @var integer
    */
    public const POWER = null;

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
    * ダメージ固定技フラグ
    * @var boolean
    */
    public const FIXED_DAMAGE_FLG = true;

    /**
    * 固定ダメージ量の取得
    * @param args:array::mixed
    * @return integer
    */
    public static function getFixedDamage(...$args): int
    {
        /**
        * @param atk:object::Pokemon 攻撃ポケモン
        * @param def:object::Pokemon 防御ポケモン
        * @param battle_state:object::BattleState バトル状態
        */
        list($atk, $def, $battle_state) = $args;
        // 攻撃ポケモンのレベル分ダメージを与える
        return $atk->getLevel();
    }

}
