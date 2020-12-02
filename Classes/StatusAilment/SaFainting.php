<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/StatusAilment.php');

/**
* ひんし
*/
class SaFainting extends StatusAilment
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'ひんし';

    /**
    * 色
    * @var string
    */
    public const COLOR = 'secondary';

    /**
    * 捕獲時の補正値
    * @var float
    */
    public const CAPTURE = 0;

}
