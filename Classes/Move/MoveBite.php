<?php

require_once(root_path('Classes').'Move.php');

// かみつく
class MoveBite extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'かみつく';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '30％の確率で敵をひるませる。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeDark';

    /**
    * 分類
    * @var string::physical:物理|special:特殊|status:変化
    */
    public const SPECIES = 'physical';

    /**
    * 威力
    * @var integer
    */
    public const POWER = 60;

    /**
    * 命中率
    * @var integer
    */
    public const ACCURACY= 100;

    /**
    * 使用回数
    * @var integer
    */
    public const PP = 25;

    /**
    * 対象
    * @var string
    */
    public const TARGET = 'enemy';

    /**
    * 追加効果
    *
    * @param args:array
    * @return mixed
    */
    public static function effects(...$args)
    {
        // 30%の確率
        if(30 < random_int(1, 100)){
            // random_intで31以上が生成されたら失敗
            return;
        }
        /**
        * @param atk:object::Pokemon 攻撃ポケモン
        * @param def:object::Pokemon 防御ポケモン
        */
        list($atk, $def) = $args;
        // 相手をひるませる
        return [
            'message' => $def->setSc('ScFlinch')
        ];
    }

}
