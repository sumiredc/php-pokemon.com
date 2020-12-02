<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

//
class MoveStub extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = '';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = '';

    /**
    * 分類
    * @var string::physical:物理|special:特殊|status:変化
    */
    public const SPECIES = '';

    /**
    * 威力
    * @var integer
    */
    public const POWER = ;

    /**
    * 命中率
    * @var integer
    */
    public const ACCURACY = ;

    /**
    * 使用回数
    * @var integer
    */
    public const PP = ;

    /**
    * 対象
    * @var string
    */
    public const TARGET = ;

    /**
    * 追加効果
    * @param args:array
    * @return void
    */
    public static function effects(...$args)
    {
        /**
        * @param atk:object::Pokemon 攻撃ポケモン
        * @param def:object::Pokemon 防御ポケモン
        */
        list($atk, $def) = $args;
    }

}
