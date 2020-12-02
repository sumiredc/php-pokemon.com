<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/StateChange.php');

/**
* 反動
*/
class ScRecoil extends StateChange
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = '反動';

    /**
    * 行動失敗
    * @var string
    */
    public const FAILED_MSG = '::pokemonは、反動で動けない';
}
