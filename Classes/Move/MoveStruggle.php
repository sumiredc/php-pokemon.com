<?php

require_once(root_path('Classes').'Move.php');

// わるあがき
class MoveStruggle extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'わるあがき';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '使用するたびに反動ダメージを受ける。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeNone';

    /**
    * 分類
    * @var string::physical:物理|special:特殊|status:変化
    */
    public const SPECIES = 'physical';

    /**
    * 威力
    * @var integer
    */
    public const POWER = 50;

    /**
    * 命中率
    * @var integer
    */
    public const ACCURACY = null;

    /**
    * 使用回数
    * @var integer
    */
    public const PP = null;

    /**
    * 対象
    * @var string
    */
    public const TARGET = 'enemy';

    /**
    * 反動
    *
    * @param args:array::mixed
    * @return array
    */
    public static function recoil(...$args)
    {
        /**
        * @param atk:object::Pokemon 攻撃ポケモン
        * @param def:object::Pokemon 防御ポケモン
        */
        list($atk, $def) = $args;

        $damage = floor($atk->getStats('H') / 4);
        $atk->calRemainingHp('sub', $damage);
        // メッセージとレスポンスを返却
        return [
            'message' => $atk->getPrefixName().'は反動を受けた',
            'response' => [
                'param' => $damage,
                'action' => 'hpbar',
                'target' => $atk->getPosition(),
            ]
        ];
    }

}
