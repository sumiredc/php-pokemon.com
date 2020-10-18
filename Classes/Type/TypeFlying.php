<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Type.php');

// ひこうタイプ
class TypeFlying extends Type
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'ひこう';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var integer
    */
    protected $excellent = ['TypeGrass', 'TypeFighting', 'TypeBug'];

    /**
    * こうかいまひとつ
    * @var integer
    */
    protected $not_very = ['TypeElectric', 'TypeRock', 'Typesteel'];

    /**
    * こうかがない
    * @var integer
    */
    protected $doesnt_affect = [];

}
