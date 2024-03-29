<?php

require_once app_path('Classes/Move.php');

// げきりん
class MoveOutrage extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'げきりん';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '使ったポケモンは次のターン、反動で動けない。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeDragon';

    /**
    * 分類
    * @var string::physical:物理|special:特殊|status:変化
    */
    public const SPECIES = 'physical';

    /**
    * 威力
    * @var integer
    */
    public const POWER = 120;

    /**
    * 命中率
    * @var integer
    */
    public const ACCURACY = 100;

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
    * @return mixed
    */
    public static function effects(...$args)
    {
        /**
        * @param atk:object::Pokemon 攻撃ポケモン
        * @param def:object::Pokemon 防御ポケモン
        */
        list($atk, $def) = $args;
        // 現在あばれる状態でなければ「あばれる状態」をセット
        if(!$atk->isSc('ScThrash')){
            // あばれる状態をセット
            $atk->setSc('ScThrash', random_int(2, 3), get_class());
        }
        // ターンカウントを進める
        $atk->goScTurn('ScThrash');
        // あばれる状態が解除されており、こんらん状態でなければ、こんらん状態にする
        if(!$atk->isSc('ScThrash') && !$atk->isSc('ScConfusion')){
            return [
                'message' => $atk->setSc('ScConfusion', random_int(1, 4))
            ];
        }
    }

}
