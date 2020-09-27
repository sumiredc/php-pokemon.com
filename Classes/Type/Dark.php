<?php
require_once(__DIR__.'/../Type.php');

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
