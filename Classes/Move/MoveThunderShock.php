<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// でんきショック
class MoveThunderShock extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'でんきショック';

    /**
    * 説明文
    * @var string
    */
    public const DESCTIPTION = '10%の確率で相手をまひ状態にする。';

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
    public const PP = 30;

    /**
    * 対象
    * @var string
    */
    public const TARGET = 'enemy';

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
        // 10%の確率
        if($def->getSa() || 10 < random_int(1, 100)){
            return;
        }
        // 相手をまひ状態にする
        return $def->setSa('SaParalysis');
    }

}
