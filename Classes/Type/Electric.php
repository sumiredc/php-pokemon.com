<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Type.php');

// でんきタイプ
class Electric extends Type
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'でんき';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var integer
    */
    protected $excellent = ['Water', 'Flying'];

    /**
    * こうかいまひとつ
    * @var integer
    */
    protected $not_very = ['Electric', 'Grass', 'Dragon'];

    /**
    * こうかがない
    * @var integer
    */
    protected $doesnt_affect = ['Ground'];

}
