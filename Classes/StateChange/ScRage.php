<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/StateChange.php');

/**
* いかり
*/
class ScRage extends StateChange
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'いかり';

    /**
    * 発動した際のメッセージ
    * @var string
    */
    public const ACTIVE_MSG = '::pokemonの怒りのボルテージが上がっていく！';

}
