<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Type.php');

// むしタイプ
class TypeBug extends Type
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'むし';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var integer
    */
    protected $excellent = ['TypePsychic', 'TypeDark', 'TypeGrass'];

    /**
    * こうかいまひとつ
    * @var integer
    */
    protected $not_very = ['TypeFire', 'TypeFighting', 'TypePoison', 'TypeFlying', 'TypeGhost', 'TypeSteel', 'TypeFairy'];

    /**
    * こうかがない
    * @var integer
    */
    protected $doesnt_affect = [];

}
