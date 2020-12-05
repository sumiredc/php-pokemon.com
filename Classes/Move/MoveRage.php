<?php

require_once(root_path('Classes').'Move.php');

// いかり
class MoveRage extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'いかり';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = 'いかり状態になり、ダメージを受けるたびにこうげきが1段階上がる。';

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
    public const POWER = 20;

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
        // 攻撃ポケモンを怒り状態にする
        $atk->setSc('ScRage');
    }

}
