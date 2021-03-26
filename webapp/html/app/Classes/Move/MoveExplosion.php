<?php

require_once app_path('Classes/Move.php');

// だいばくはつ
class MoveExplosion extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'だいばくはつ';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '使ったポケモンはひんしになる。';

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
    public const POWER = 250;

    /**
    * 命中率
    * @var integer
    */
    public const ACCURACY = 100;

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
    * 技の使用コスト(技の成功・失敗に問わず発生)
    * @param arg:array
    * @return void
    */
    public static function cost(...$args)
    {
        /**
        * @param atk:object::Pokemon 攻撃ポケモン
        * @param def:object::Pokemon 防御ポケモン
        */
        list($atk, $def) = $args;
        // 瀕死処理の前に、攻撃ポケモンの残りHPをダメージとしてセット
        $msg_id = response()->issueMsgId();
        response()->setResponse([
            'param' => $atk->getRemainingHp(),
            'action' => 'hpbar',
            'target' => $atk->getPosition(),
        ], $msg_id);
        response()->setAutoMessage($msg_id);
        // 攻撃ポケモンに対して即死処理
        $atk->calRemainingHp('death');
    }

}
