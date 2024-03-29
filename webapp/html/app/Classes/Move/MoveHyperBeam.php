<?php

require_once app_path('Classes/Move.php');

// はかいこうせん
class MoveHyperBeam extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'はかいこうせん';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '使ったポケモンは次のターン、反動で動けない。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeNormal';

    /**
    * 分類
    * @var string::physical:物理|special:特殊|status:変化
    */
    public const SPECIES = 'special';

    /**
    * 威力
    * @var integer
    */
    public const POWER = 150;

    /**
    * 命中率
    * @var integer
    */
    public const ACCURACY = 90;

    /**
    * 使用回数
    * @var integer
    */
    public const PP = 5;

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
        // はんどうをセット
        $atk->setSc('ScRecoil');
    }

}
