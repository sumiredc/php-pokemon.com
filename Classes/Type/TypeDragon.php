<?php

require_once(root_path('Classes').'Type.php');

// ドラゴンタイプ
class TypeDragon extends Type
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'ドラゴン';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var array
    */
    public const EXCELLENT = ['TypeDragon'];

    /**
    * こうかいまひとつ
    * @var array
    */
    public const NOT_VERY = ['TypeSteel'];

    /**
    * こうかがない
    * @var array
    */
    public const DOESNT_AFFECT = ['TypeFairy'];

}
