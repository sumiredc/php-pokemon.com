<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Type.php');

// ほのおタイプ
class TypeFire extends Type
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'ほのお';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var integer
    */
    protected $excellent = ['TypeGrass', 'TypeIce', 'TypeBug', 'TypeSteel'];

    /**
    * こうかいまひとつ
    * @var integer
    */
    protected $not_very = ['TypeFire', 'TypeWater', 'TypeRock', 'TypeDragon'];

    /**
    * こうかがない
    * @var integer
    */
    protected $doesnt_affect = [];

}
