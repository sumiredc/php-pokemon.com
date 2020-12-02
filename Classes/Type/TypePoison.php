<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Type.php');

// どくタイプ
class TypePoison extends Type
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'どく';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var array
    */
    public const EXCELLENT = ['TypeGrass', 'TypeFairy'];

    /**
    * こうかいまひとつ
    * @var array
    */
    public const NOT_VERY = ['TypePoison', 'TypeGround', 'TypeRock', 'TypeGhost'];

    /**
    * こうかがない
    * @var array
    */
    public const DOESNT_AFFECT = ['TypeSteel'];

}
