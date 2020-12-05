<?php

require_once(root_path('Classes').'Type.php');

// ひこうタイプ
class TypeFlying extends Type
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'ひこう';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var array
    */
    public const EXCELLENT = ['TypeGrass', 'TypeFighting', 'TypeBug'];

    /**
    * こうかいまひとつ
    * @var array
    */
    public const NOT_VERY = ['TypeElectric', 'TypeRock', 'Typesteel'];

    /**
    * こうかがない
    * @var array
    */
    public const DOESNT_AFFECT = [];

}
