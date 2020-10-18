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
    protected $name = 'かくとう';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var integer
    */
    protected $excellent = ['TypeNormal', 'TypeIce', 'TypeRock', 'TypeDark', 'TypeSteel'];

    /**
    * こうかいまひとつ
    * @var integer
    */
    protected $not_very = ['TypePison', 'TypeFlying', 'TypePsychic', 'TypeBug', 'TypeFairy'];

    /**
    * こうかがない
    * @var integer
    */
    protected $doesnt_affect = ['Ghost'];

}
