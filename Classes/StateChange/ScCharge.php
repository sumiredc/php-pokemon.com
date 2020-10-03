<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/StateChange.php');

// チャージ
class ScCharge extends StateChange
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'チャージ';

    /**
    * 状態変化にかかった際のメッセージ
    * @var string
    */
    protected $sicked_msg = [
        'SkullBash' => '::pokemonは、頭を引っ込めた',
        'SolarBeam' => '::pokemonは、光を吸収した',
    ];

}
