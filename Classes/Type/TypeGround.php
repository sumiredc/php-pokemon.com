<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Type.php');

// じめんタイプ
class TypeGround extends Type
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'じめん';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var integer
    */
    protected $excellent = ['TypeFire', 'TypeElectric', 'TypePoison', 'TypeRock', 'TypeSteel'];

    /**
    * こうかいまひとつ
    * @var integer
    */
    protected $not_very = ['TypeGrass', 'TypeBug'];

    /**
    * こうかがない
    * @var integer
    */
    protected $doesnt_affect = ['TypeFlying'];

}
