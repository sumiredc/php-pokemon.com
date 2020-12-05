<?php

require_once(root_path('Classes').'Type.php');

// ゴーストタイプ
class TypeGhost extends Type
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'ゴースト';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var array
    */
    public const EXCELLENT = ['TypePsychic', 'TypeGhost'];

    /**
    * こうかいまひとつ
    * @var array
    */
    public const NOT_VERY = ['TypeDark'];

    /**
    * こうかがない
    * @var array
    */
    public const DOESNT_AFFECT = ['TypeNormal'];

}
