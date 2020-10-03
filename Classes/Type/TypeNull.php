<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Type.php');

// タイプ無し
class TypeNull extends Type
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = '';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var integer
    */
    protected $excellent = [];

    /**
    * こうかいまひとつ
    * @var integer
    */
    protected $not_very = [];

    /**
    * こうかがない
    * @var integer
    */
    protected $doesnt_affect = [];

}
