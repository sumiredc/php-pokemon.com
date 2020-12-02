<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

//かぜおこし
class MoveGust extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'かぜおこし';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = 'そらをとぶ状態のポケモンにも命中し、その場合は威力が2倍になる。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeFlying';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    public const SPECIES = 'special';

    /**
    * 威力
    * @var integer
    */
    public const POWER = 40;

    /**
    * 命中率
    * @var integer
    */
    public const ACCURACY = 100;

    /**
    * 使用回数
    * @var integer
    */
    public const PP = 35;

    /**
    * 対象
    * @var string
    */
    public const TARGET = 'enemy';

    /**
    * 威力補正値の取得
    * @param mixed
    * @return integer
    */
    public static function powerCorrection(...$args): int
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

}
