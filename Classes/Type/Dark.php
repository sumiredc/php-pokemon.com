<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Type.php');

// あくタイプ
class Dark extends Type
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'あく';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var integer
    */
    protected $excellent = ['Psychic', 'Ghost'];

    /**
    * こうかいまひとつ
    * @var integer
    */
    protected $not_very = ['Fighting', 'Dark', 'Fairy'];

    /**
    * こうかがない
    * @var integer
    */
    protected $doesnt_affect = [];

}
