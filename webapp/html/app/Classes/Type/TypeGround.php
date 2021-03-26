<?php

require_once app_path('Classes/Type.php');

// じめんタイプ
class TypeGround extends Type
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'じめん';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var array
    */
    public const EXCELLENT = ['TypeFire', 'TypeElectric', 'TypePoison', 'TypeRock', 'TypeSteel'];

    /**
    * こうかいまひとつ
    * @var array
    */
    public const NOT_VERY = ['TypeGrass', 'TypeBug'];

    /**
    * こうかがない
    * @var array
    */
    public const DOESNT_AFFECT = ['TypeFlying'];

}
