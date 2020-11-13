<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/StateChange.php');

// へんしん
class ScTransform extends StateChange
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'へんしん';

}
