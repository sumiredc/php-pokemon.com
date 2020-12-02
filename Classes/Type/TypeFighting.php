<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Type.php');

// かくとうタイプ
class TypeFighting extends Type
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'かくとう';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var array
    */
    public const EXCELLENT = ['TypeNormal', 'TypeIce', 'TypeRock', 'TypeDark', 'TypeSteel'];

    /**
    * こうかいまひとつ
    * @var array
    */
    public const NOT_VERY = ['TypePison', 'TypeFlying', 'TypePsychic', 'TypeBug', 'TypeFairy'];

    /**
    * こうかがない
    * @var array
    */
    public const DOESNT_AFFECT = ['Ghost'];

}
