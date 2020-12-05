<?php

require_once(root_path('Classes').'Type.php');

// くさタイプ
class TypeGrass extends Type
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'くさ';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var array
    */
    public const EXCELLENT = ['TypeWater', 'TypeGround', 'TypeRock'];

    /**
    * こうかいまひとつ
    * @var array
    */
    public const NOT_VERY = ['TypeFire', 'TypeGrass', 'TypePoison', 'TypeFlying', 'TypeBug', 'TypeDragon', 'TypeSteel'];

    /**
    * こうかがない
    * @var array
    */
    public const DOESNT_AFFECT = [];

}
