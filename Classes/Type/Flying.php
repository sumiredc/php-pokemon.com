<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Type.php');

// ひこうタイプ
class Flying extends Type
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'ひこう';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var integer
    */
    protected $excellent = ['Grass', 'Fighting', 'Bug'];

    /**
    * こうかいまひとつ
    * @var integer
    */
    protected $not_very = ['Electric', 'Rock', 'steel'];

    /**
    * こうかがない
    * @var integer
    */
    protected $doesnt_affect = [];

}
