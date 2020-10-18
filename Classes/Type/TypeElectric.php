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
    protected $name = 'でんき';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var integer
    */
    protected $excellent = ['TypeWater', 'TypeFlying'];

    /**
    * こうかいまひとつ
    * @var integer
    */
    protected $not_very = ['TypeElectric', 'TypeGrass', 'TypeDragon'];

    /**
    * こうかがない
    * @var integer
    */
    protected $doesnt_affect = ['TypeGround'];

}
