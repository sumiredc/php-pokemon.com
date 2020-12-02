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
    public const NAME = 'ほのお';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var array
    */
    public const EXCELLENT = ['TypeGrass', 'TypeIce', 'TypeBug', 'TypeSteel'];

    /**
    * こうかいまひとつ
    * @var array
    */
    public const NOT_VERY = ['TypeFire', 'TypeWater', 'TypeRock', 'TypeDragon'];

    /**
    * こうかがない
    * @var array
    */
    public const DOESNT_AFFECT = [];

}
