<?php

require_once(root_path('Classes').'Type.php');

// いわタイプ
class TypeRock extends Type
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'いわ';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var integer
    */
    public const EXCELLENT = ['TypeFire', 'TypeIce', 'TypeFlying', 'TypeBug'];

    /**
    * こうかいまひとつ
    * @var integer
    */
    public const NOT_VERY = ['TypeFighting', 'TypeGround', 'TypeSteel'];

    /**
    * こうかがない
    * @var integer
    */
    public const DOESNT_AFFECT = [];

}
