<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Type.php');

// あくタイプ
class TypeDark extends Type
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'あく';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var integer
    */
    protected $excellent = ['TypePsychic', 'TypeGhost'];

    /**
    * こうかいまひとつ
    * @var integer
    */
    protected $not_very = ['TypeFighting', 'TypeDark', 'TypeFairy'];

    /**
    * こうかがない
    * @var integer
    */
    protected $doesnt_affect = [];

}