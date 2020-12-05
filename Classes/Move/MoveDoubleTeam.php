<?php

require_once(root_path('Classes').'Move.php');

// かげぶんしん
class MoveDoubleTeam extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'かげぶんしん';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '自分の回避率を1段階上げる。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeNormal';

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
    public const PP = 15;

    /**
    * 対象
    * @var string
    */
    public const TARGET = 'friend';

    /**
    * 追加効果
    *
    * @param args:array
    * @return void
    */
    public static function effects(...$args)
    {
        /**
        * @param atk:object::Pokemon 攻撃ポケモン
        * @param def:object::Pokemon 防御ポケモン
        */
        list($atk, $def) = $args;
        // 自分の回避率ランクを1段階上げる
        return [
            'message' => $atk->addRank('Evasion', 1)
        ];
    }

}
