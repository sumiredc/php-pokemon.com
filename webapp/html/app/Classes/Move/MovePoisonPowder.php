<?php

require_once app_path('Classes/Move.php');

// どくのこな
class MovePoisonPowder extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'どくのこな';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '相手をどく状態にする。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypePoison';

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
    public const PP = 35;

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
        // 相手をどく状態にする
        return $def->setSa('SaPoison');
    }

}
