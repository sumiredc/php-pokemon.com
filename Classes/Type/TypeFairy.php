<?php

require_once(root_path('Classes').'Type.php');

// フェアリータイプ
class TypeFairy extends Type
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'フェアリー';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var array
    */
    public const EXCELLENT = ['TypeFighting', 'TypeDragon', 'TypeDark'];

    /**
    * こうかいまひとつ
    * @var array
    */
    public const NOT_VERY = ['TypeFire', 'TypePoison', 'TypeSteel'];

    /**
    * こうかがない
    * @var array
    */
    public const DOESNT_AFFECT = [];

}
