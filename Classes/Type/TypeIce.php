<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Type.php');

// こおりタイプ
class TypeIce extends Type
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'こおり';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var integer
    */
    protected $excellent = ['TypeGrass', 'TypeGround', 'TypeFlying', 'TypeDragon'];

    /**
    * こうかいまひとつ
    * @var integer
    */
    protected $not_very = ['TypeFire', 'TypeWater', 'TypeIce', 'TypeSteel'];

    /**
    * こうかがない
    * @var integer
    */
    protected $doesnt_affect = [];

}
