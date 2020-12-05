<?php

require_once(root_path('Classes').'Type.php');

// あくタイプ
class TypeDark extends Type
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'あく';

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
    public const NOT_VERY = ['TypeFighting', 'TypeDark', 'TypeFairy'];

    /**
    * こうかがない
    * @var array
    */
    public const DOESNT_AFFECT = [];

}
