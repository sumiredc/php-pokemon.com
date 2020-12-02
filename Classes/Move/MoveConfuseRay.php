<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// あやしいひかり
class MoveConfuseRay extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'あやしいひかり';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '相手をこんらん状態にする。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeGhost';

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
    * 追加効果
    *
    * @param array $args
    * @return void
    */
    public static function effects(...$args)
    {
        /**
        * @param atk:object::Pokemon 攻撃ポケモン
        * @param def:object::Pokemon 防御ポケモン
        */
        list($atk, $def) = $args;
        // 相手をこんらん状態にする
        return [
            'message' => $def->setSc('ScConfusion', random_int(1, 4))
        ];
    }

}
