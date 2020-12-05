<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// すなかけ
class MoveSandAttack extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'すなかけ';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '相手の命中率を1段階下げる。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeGround';

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
    * 能力下降確定技フラグ
    * @var boolean
    */
    public const CONFIRM_DEBUFF_FLG = true;

    /**
    * 能力下降効果
    *
    * @param args:array
    * @return array
    */
    public static function debuff(...$args)
    {
        /**
        * @param atk:object::Pokemon 攻撃ポケモン
        * @param def:object::Pokemon 防御ポケモン
        */
        list($atk, $def) = $args;
        // 相手の命中ランクを1段階下げる
        return [
            'message' => $def->subRank('Accuracy', 1)
        ];
    }

}
