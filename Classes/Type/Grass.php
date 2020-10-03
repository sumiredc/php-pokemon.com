<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Type.php');

// くさタイプ
class Grass extends Type
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'くさ';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var integer
    */
    protected $excellent = ['Water', 'Ground', 'Rock'];

    /**
    * こうかいまひとつ
    * @var integer
    */
    protected $not_very = ['Fire', 'Grass', 'Poison', 'Flying', 'Bug', 'Dragon', 'Steel'];

    /**
    * こうかがない
    * @var integer
    */
    protected $doesnt_affect = [];

}
