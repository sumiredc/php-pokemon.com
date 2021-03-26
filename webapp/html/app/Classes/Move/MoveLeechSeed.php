<?php

require_once app_path('Classes/Move.php');

// やどりぎのタネ
class MoveLeechSeed extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'やどりぎのタネ';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '相手をやどりぎのタネ状態にし、毎ターン相手の最大HPの1/8を奪って、その分自分のHPを回復を回復させる。自分が交代しても効果は続く。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeGrass';

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
    public const ACCURACY = 90;

    /**
    * 使用回数
    * @var integer
    */
    public const PP = 10;

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
        // 相手をやどりぎのタネ状態にする
        return [
            'message' => $def->setSc('ScLeechSeed')
        ];
    }

}
