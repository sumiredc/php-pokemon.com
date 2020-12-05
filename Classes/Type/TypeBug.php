<?php

require_once(root_path('Classes').'Type.php');

// むしタイプ
class TypeBug extends Type
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'むし';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var array
    */
    public const EXCELLENT = ['TypePsychic', 'TypeDark', 'TypeGrass'];

    /**
    * こうかいまひとつ
    * @var array
    */
    public const NOT_VERY = ['TypeFire', 'TypeFighting', 'TypePoison', 'TypeFlying', 'TypeGhost', 'TypeSteel', 'TypeFairy'];

    /**
    * こうかがない
    * @var array
    */
    public const DOESNT_AFFECT = [];

}
