<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Type.php');

// かくとうタイプ
class Fighting extends Type
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'かくとう';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var integer
    */
    protected $excellent = ['Normal', 'Ice', 'Rock', 'Dark', 'Steel'];

    /**
    * こうかいまひとつ
    * @var integer
    */
    protected $not_very = ['Pison', 'Flying', 'Psychic', 'Bug', 'Fairy'];

    /**
    * こうかがない
    * @var integer
    */
    protected $doesnt_affect = ['Ghost'];

}
