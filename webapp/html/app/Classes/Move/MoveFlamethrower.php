<?php

require_once app_path('Classes/Move.php');

// かえんほうしゃ
class MoveFlamethrower extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'かえんほうしゃ';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '10％の確率で相手をやけど状態にする。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeFire';

    /**
    * 分類
    * @var string::physical:物理|special:特殊|status:変化
    */
    public const SPECIES = 'special';

    /**
    * 威力
    * @var integer
    */
    public const POWER = 90;

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
        // 相手が状態異常にかかっていない
        // 10%の確率
        if(
            $def->getSa() ||
            10 < random_int(1, 100)
        ){
            return;
        }
        // 相手をやけど状態にする
        return $def->setSa('SaBurn');
    }

}
