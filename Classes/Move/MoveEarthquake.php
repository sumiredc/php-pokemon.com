<?php

require_once(root_path('Classes').'Move.php');

// じしん
class MoveEarthquake extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'じしん';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = 'あなをほる状態のポケモンにも命中し、2倍のダメージを与えられる。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeGround';

    /**
    * 分類
    * @var string::physical:物理|special:特殊|status:変化
    */
    public const SPECIES = 'physical';

    /**
    * 威力
    * @var integer
    */
    public const POWER = 100;

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
    * 威力補正値の取得
    *
    * @param mixed
    * @return integer
    */
    public static function powerCorrection(...$args): int
    {
        /**
        * @param atk:object::Pokemon 攻撃ポケモン
        * @param def:object::Pokemon 防御ポケモン
        */
        list($atk, $def) = $args;
        // もし相手があなをほるチャージ中なら威力2倍
        if($def->getChargeMove() === 'MoveDig'){
            return 2;
        }
        // 通常補正値
        return 1;
    }

}
