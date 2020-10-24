<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/StateChange.php');

// バインド
class ScBind extends StateChange
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'バインド';

    /**
    * 状態変化にかかった際のメッセージ
    * @var string
    */
    protected $sicked_msg = [
        'Standard' => '::pokemonは、しめつけられた',
        'MoveFireSpin' => '::pokemonは、ほのおのうずに閉じ込められた',
    ];

    /**
    * ターンチェック時に表示されるメッセージ
    * @var string
    */
    protected $turn_msg = [
        'Standard' => '::pokemonは、しめつけられている',
        'MoveFireSpin' => '::pokemonは、ほのおのうずに巻き込まれている',
    ];

    /**
    * 回復時に表示されるメッセージ
    * @var string
    */
    protected $recovery_msg = [
        'Standard' => '::pokemonは、しめつけから開放された',
        'MoveFireSpin' => '::pokemonは、ほのおのうずから抜け出した',
    ];

}
