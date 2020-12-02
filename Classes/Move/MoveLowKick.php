<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// けたぐり
class MoveLowKick extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'けたぐり';

    /**
    * 説明文
    * @var string
    */
    public const DESCTIPTION = '相手の重さによって威力が変わる。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeFighting';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    public const SPECIES = 'physical';

    /**
    * 威力
    * @var integer|null
    */
    public const POWER = null;

    /**
    * 命中率
    * @var integer
    */
    public const ACCURACY = 100;

    /**
    * 使用回数
    * @var integer
    */
    public const PP = 20;

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
        // 防御ポケモンの重さを取得
        $weight_list = [0, 10, 25, 50, 100, 200];
        $power = array_map(function($weight) use($def){
            if($def->getWeight() >= $weight){
                return 20;
            }else{
                return 0;
            }
        }, $weight_list);
        // 威力合計値を補正値として返却
        return array_sum($power);
    }

}
