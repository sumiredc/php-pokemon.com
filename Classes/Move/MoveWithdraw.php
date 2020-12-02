<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// からにこもる
class MoveWithdraw extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'からにこもる';

    /**
    * 説明文
    * @var string
    */
    public const DESCTIPTION = '自分のぼうぎょを1段階上げる。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeWater';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    public const SPECIES = 'status';

    /**
    * 威力
    * @var integer
    */
    public const POWER = null;

    /**
    * 命中率
    * @var integer
    */
    public const ACCURACY = null;

    /**
    * 使用回数
    * @var integer
    */
    public const PP = 40;

    /**
    * 対象
    * @var string
    */
    public const TARGET = 'friend';

    /**
    * 追加効果
    *
    * @param array $args
    * @return array
    */
    public static function effects(...$args)
    {
        /**
        * @param Pokemon $atk 攻撃ポケモン
        * @param Pokemon $def 防御ポケモン
        */
        list($atk, $def) = $args;
        // 自分の防御ランクを1段階上げる
        return [
            'message' => $atk->addRank('Defense', 1)
        ];
    }

}
