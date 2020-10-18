<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Type.php');

// どくタイプ
class TypePoison extends Type
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'どく';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var integer
    */
    protected $excellent = ['TypeGrass', 'TypeFairy'];

    /**
    * こうかいまひとつ
    * @var integer
    */
    protected $not_very = ['TypePoison', 'TypeGround', 'TypeRock', 'TypeGhost'];

    /**
    * こうかがない
    * @var integer
    */
    protected $doesnt_affect = ['TypeSteel'];

}
