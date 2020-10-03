<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Type.php');

// むしタイプ
class Bug extends Type
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'むし';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var integer
    */
    protected $excellent = ['Psychic', 'Dark', 'Grass'];

    /**
    * こうかいまひとつ
    * @var integer
    */
    protected $not_very = ['Fire', 'Fighting', 'Poison', 'Flying', 'Ghost', 'Steel', 'Fairy'];

    /**
    * こうかがない
    * @var integer
    */
    protected $doesnt_affect = [];

}
