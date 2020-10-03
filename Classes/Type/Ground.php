<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Type.php');

// じめんタイプ
class Ground extends Type
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'じめん';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var integer
    */
    protected $excellent = ['Fire', 'Electric', 'Poison', 'Rock', 'Steel'];

    /**
    * こうかいまひとつ
    * @var integer
    */
    protected $not_very = ['Grass', 'Bug'];

    /**
    * こうかがない
    * @var integer
    */
    protected $doesnt_affect = ['Flying'];

}
