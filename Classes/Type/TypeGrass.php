<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Type.php');

// くさタイプ
class TypeGrass extends Type
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'くさ';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var integer
    */
    protected $excellent = ['TypeWater', 'TypeGround', 'TypeRock'];

    /**
    * こうかいまひとつ
    * @var integer
    */
    protected $not_very = ['TypeFire', 'TypeGrass', 'TypePoison', 'TypeFlying', 'TypeBug', 'TypeDragon', 'TypeSteel'];

    /**
    * こうかがない
    * @var integer
    */
    protected $doesnt_affect = [];

}
