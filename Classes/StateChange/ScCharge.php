<?php

require_once(root_path('Classes').'StateChange.php');

/**
* チャージ
*/
class ScCharge extends StateChange
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'チャージ';

    /**
    * 状態変化にかかった際のメッセージ
    * @var string
    */
    public const SICKED_MSG = [
        'MoveSkullBash' => '::pokemonは、頭を引っ込めた',
        'MoveSolarBeam' => '::pokemonは、光を吸収した',
        'MoveFly' => '::pokemonは、空高く飛び上がった',
        'MoveDig' => '::pokemonは、地中深く潜った',
    ];

}
