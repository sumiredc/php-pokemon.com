<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// あわ
class MoveBubble extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'あわ';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '10%の確率ですばやさを1段階下げる。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeWater';

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
    * 能力下降効果
    *
    * @param args:array
    * @return array
    */
    public static function debuff(...$args)
    {
        // 10%の確率
        if(10 < random_int(1, 100)){
            // random_intで11以上が生成されたら失敗
            return;
        }
        /**
        * @param Pokemon:object $atk 攻撃ポケモン
        * @param Pokemon:object $def 防御ポケモン
        */
        list($atk, $def) = $args;
        // 相手の素早さランクを1段階下げる
        return [
            'message' => $def->subRank('Speed', 1)
        ];
    }

}
