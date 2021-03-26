<?php

require_once app_path('Classes/Type.php');

// こおりタイプ
class TypeIce extends Type
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'こおり';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var array
    */
    public const EXCELLENT = ['TypeGrass', 'TypeGround', 'TypeFlying', 'TypeDragon'];

    /**
    * こうかいまひとつ
    * @var array
    */
    public const NOT_VERY = ['TypeFire', 'TypeWater', 'TypeIce', 'TypeSteel'];

    /**
    * こうかがない
    * @var array
    */
    public const DOESNT_AFFECT = [];

}
