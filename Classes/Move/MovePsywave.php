<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// サイコウェーブ
class MovePsywave extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'サイコウェーブ';

    /**
    * 説明文
    * @var string
    */
    public const DESCTIPTION = '相手にランダムに決まった値を固定ダメージとして与える。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypePsychic';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    public const SPECIES = 'special';

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
    public const PP = 15;

    /**
    * 対象
    * @var string
    */
    public const TARGET = 'enemy';

    /**
    * 固定ダメージフラグ
    * @var boolean
    */
    public const FIXED_DAMAGE_FLG = true;

    /**
    * 固定ダメージ量の取得
    *
    * @param args:array
    * @return integer
    */
    public static function getFixedDamage(...$args)
    {
        /**
        * @param atk:object::Pokemon 攻撃ポケモン
        * @param def:object::Pokemon 防御ポケモン
        * @param battle_state:object::BattleState バトル状態
        */
        list($atk, $def, $battle_state) = $args;
        // 攻撃ポケモンのレベル*(0.5〜1.5)倍のダメージを与える
        $damage = (int)($atk->getLevel() * (random_int(5, 15) / 10));
        // 最小ダメージの処理
        if(empty($damage)){
            $damage = 1;
        }
        return $damage;
    }

}
