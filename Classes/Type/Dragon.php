<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Type.php');

// ドラゴンタイプ
class Dragon extends Type
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'ドラゴン';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var integer
    */
    protected $excellent = ['Dragon'];

    /**
    * こうかいまひとつ
    * @var integer
    */
    protected $not_very = ['Steel'];

    /**
    * こうかがない
    * @var integer
    */
    protected $doesnt_affect = ['Fairy'];

}
