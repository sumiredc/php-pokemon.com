<?php

require_once(root_path('Classes').'Type.php');

// タイプ無し
class TypeNone extends Type
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = '';

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
    public const NOT_VERY = [];

    /**
    * こうかがない
    * @var array
    */
    public const DOESNT_AFFECT = [];

}
