<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Type.php');

// みずタイプ
class Water extends Type
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'みず';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var integer
    */
    protected $excellent = ['Fire', 'Ground', 'Rock'];

    /**
    * こうかいまひとつ
    * @var integer
    */
    protected $not_very = ['Water', 'Grass', 'Dragon'];

    /**
    * こうかがない
    * @var integer
    */
    protected $doesnt_affect = [];

}
