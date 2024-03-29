<?php

require_once app_path('Classes/Move.php');

// ほのおのうず
class MoveFireSpin extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'ほのおのうず';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '相手をバインド状態にし、2〜5ターン連続でHPを減らし続ける。相手は逃げたり交換したりすることができなくなる。';

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
    public const POWER = 35;

    /**
    * 命中率
    * @var integer
    */
    public const ACCURACY = 85;

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
        // 相手をバインド状態にする
        return [
            'message' => $def->setSc('ScBind', random_int(2, 5), get_class())
        ];
    }

}
