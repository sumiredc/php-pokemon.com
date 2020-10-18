<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Type.php');

// はがねタイプ
class TypeSteel extends Type
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'はがね';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var integer
    */
    protected $excellent = ['TypeIce', 'TypeRock', 'TypeFaily'];

    /**
    * こうかいまひとつ
    * @var integer
    */
    protected $not_very = ['TypeFire', 'TypeWater', 'TypeElectric', 'TypeSteel'];

    /**
    * こうかがない
    * @var integer
    */
    protected $doesnt_affect = [];

}
