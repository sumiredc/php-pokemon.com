<?php

require_once(root_path('Classes').'Move.php');

// せいちょう
class MoveGrowth extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'せいちょう';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '自分のこうげきととくこうをそれぞれ1段階ずつ上げる。';

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
    public const PP = 20;

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
        return [
            'message' => [
                $atk->addRank('A', 1), # 自分の攻撃ランクを1段階上げる
                $atk->addRank('C', 1)  # 自分の特攻ランクを1段階上げる
            ]
        ];
    }

}
