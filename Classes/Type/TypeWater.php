<?php

require_once(root_path('Classes').'Type.php');

// みずタイプ
class TypeWater extends Type
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'みず';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var integer
    */
    public const EXCELLENT = ['TypeFire', 'TypeGround', 'TypeRock'];

    /**
    * こうかいまひとつ
    * @var integer
    */
    public const NOT_VERY = ['TypeWater', 'TypeGrass', 'TypeDragon'];

    /**
    * こうかがない
    * @var integer
    */
    public const DOESNT_AFFECT = [];

}
