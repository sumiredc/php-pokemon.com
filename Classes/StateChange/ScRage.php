<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/StateChange.php');

// いかり
class ScRage extends StateChange
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'いかり';

    /**
    * 発動した際のメッセージ
    * @var string
    */
    protected $active_msg = '::pokemonの怒りのボルテージが上がっていく！';

}
