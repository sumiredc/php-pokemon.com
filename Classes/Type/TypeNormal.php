<?php

require_once(root_path('Classes').'Type.php');

// ノーマルタイプ
class TypeNormal extends Type
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'ノーマル';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var array
    */
    public const EXCELLENT = [];

    /**
    * こうかいまひとつ
    * @var array
    */
    public const NOT_VERY = ['TypeRock', 'TypeSteel'];

    /**
    * こうかがない
    * @var array
    */
    public const DOESNT_AFFECT = ['TypeGhost'];

}
