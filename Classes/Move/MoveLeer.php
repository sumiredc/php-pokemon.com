<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// にらみつける
class MoveLeer extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'にらみつける';

    /**
    * 説明文
    * @var string
    */
    public const DESCTIPTION = '相手のぼうぎょを1段階下げる。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeNormal';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
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
    public const PP = 30;

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
    * @param array $args
    * @return void
    */
    public static function debuff(...$args)
    {
        /**
        * @param Pokemon $atk 攻撃ポケモン
        * @param Pokemon $def 防御ポケモン
        */
        list($atk, $def) = $args;
        // 相手の防御ランクを1段階下げる
        return [
            'message' => $def->subRank('Defense', 1)
        ];
    }

}
