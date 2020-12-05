<?php

require_once(root_path('Classes').'Type.php');

// はがねタイプ
class TypeSteel extends Type
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'はがね';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var integer
    */
    public const EXCELLENT = ['TypeIce', 'TypeRock', 'TypeFaily'];

    /**
    * こうかいまひとつ
    * @var integer
    */
    public const NOT_VERY = ['TypeFire', 'TypeWater', 'TypeElectric', 'TypeSteel'];

    /**
    * こうかがない
    * @var integer
    */
    public const DOESNT_AFFECT = [];

}
