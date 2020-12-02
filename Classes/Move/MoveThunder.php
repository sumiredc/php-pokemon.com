<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// かみなり
class MoveThunder extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'かみなり';

    /**
    * 説明文
    * @var string
    */
    public const DESCTIPTION = '30％の確立で相手をまひ状態にする。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeElectric';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    public const SPECIES = 'special';

    /**
    * 威力
    * @var integer
    */
    public const POWER = 110;

    /**
    * 命中率
    * @var integer
    */
    public const ACCURACY = 70;

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
    public static function powerCorrection(...$args)
    {
        /**
        * @param Pokemon:object $atk 攻撃ポケモン
        * @param Pokemon:object $def 防御ポケモン
        */
        list($atk, $def) = $args;
        // もし相手がそらをとぶチャージ中なら威力2倍
        if($def->getChargeMove() === 'MoveFly'){
            return 2;
        }
        // 通常補正値
        return 1;
    }

    /**
    * 追加効果
    *
    * @param array $args
    * @return mixed
    */
    public static function effects(...$args)
    {
        /**
        * @param Pokemon $atk 攻撃ポケモン
        * @param Pokemon $def 防御ポケモン
        */
        list($atk, $def) = $args;
        // 相手が状態異常にかかっていない
        // 30%の確率
        if($def->getSa() || 30 < random_int(1, 100)){
            return;
        }
        // 相手をまひ状態にする
        return $def->setSa('SaParalysis');
    }

}
