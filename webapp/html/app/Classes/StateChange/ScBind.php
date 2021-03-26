<?php

require_once app_path('Classes/StateChange.php');

/**
* バインド
*/
class ScBind extends StateChange
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'バインド';

    /**
    * 状態変化にかかった際のメッセージ
    * @var string
    */
    public const SICKED_MSG = [
        0 => '::pokemonは、しめつけられた',
        'MoveFireSpin' => '::pokemonは、ほのおのうずに閉じ込められた',
    ];

    /**
    * ターンチェック時に表示されるメッセージ
    * @var string
    */
    public const TURN_MSG = [
        0 => '::pokemonは、しめつけられている',
        'MoveFireSpin' => '::pokemonは、ほのおのうずに巻き込まれている',
    ];

    /**
    * 回復時に表示されるメッセージ
    * @var string
    */
    public const RECOVERY_MSG = [
        0 => '::pokemonは、しめつけから開放された',
        'MoveFireSpin' => '::pokemonは、ほのおのうずから抜け出した',
    ];

}
