<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// ふきとばし
class MoveWhirlwind extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'ふきとばし';

    /**
    * 説明文
    * @var string
    */
    public const DESCTIPTION = '野生ポケモンとの戦闘を終了させる。トレーナー戦で使うと、相手ポケモンをランダムに交代させる。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeNormal';

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
    public const PP = 20;

    /**
    * 優先度
    * @var integer
    */
    public const PRIORITY = -6;

    /**
    * 対象
    * @var string
    */
    public const TARGET = 'enemy';

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
        // バトル終了
        return [
            'message' => $def->getPrefixName().'は吹き飛ばされた',
            'end' => true
        ];
    }

}
