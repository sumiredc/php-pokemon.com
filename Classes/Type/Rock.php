<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Type.php');

// いわタイプ
class Rock extends Type
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'いわ';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var integer
    */
    protected $excellent = ['Fire', 'Ice', 'Flying', 'Bug'];

    /**
    * こうかいまひとつ
    * @var integer
    */
    protected $not_very = ['Fighting', 'Ground', 'Steel'];

    /**
    * こうかがない
    * @var integer
    */
    protected $doesnt_affect = [];

}
