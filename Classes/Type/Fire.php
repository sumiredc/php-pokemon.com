<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Type.php');

// ほのおタイプ
class Fire extends Type
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'ほのお';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var integer
    */
    protected $excellent = ['Grass', 'Ice', 'Bug', 'Steel'];

    /**
    * こうかいまひとつ
    * @var integer
    */
    protected $not_very = ['Fire', 'Water', 'Rock', 'Dragon'];

    /**
    * こうかがない
    * @var integer
    */
    protected $doesnt_affect = [];

}
