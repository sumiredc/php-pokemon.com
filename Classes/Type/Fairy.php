<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Type.php');

// フェアリータイプ
class Fairy extends Type
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'フェアリー';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var integer
    */
    protected $excellent = ['Fighting', 'Dragon', 'Dark'];

    /**
    * こうかいまひとつ
    * @var integer
    */
    protected $not_very = ['Fire', 'Poison', 'Steel'];

    /**
    * こうかがない
    * @var integer
    */
    protected $doesnt_affect = [];

}
