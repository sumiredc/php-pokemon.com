<?php
require_once(__DIR__.'/../Type.php');

// はがねタイプ
class Steel extends Type
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'はがね';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var integer
    */
    protected $excellent = ['Ice', 'Rock', 'Faily'];

    /**
    * こうかいまひとつ
    * @var integer
    */
    protected $not_very = ['Fire', 'Water', 'Electric', 'Steel'];

    /**
    * こうかがない
    * @var integer
    */
    protected $doesnt_affect = [];

}
