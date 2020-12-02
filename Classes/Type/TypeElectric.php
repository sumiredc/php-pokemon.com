<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Type.php');

// でんきタイプ
class TypeElectric extends Type
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'でんき';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var array
    */
    public const EXCELLENT = ['TypeWater', 'TypeFlying'];

    /**
    * こうかいまひとつ
    * @var array
    */
    public const NOT_VERY = ['TypeElectric', 'TypeGrass', 'TypeDragon'];

    /**
    * こうかがない
    * @var array
    */
    public const DOESNT_AFFECT = ['TypeGround'];

}
