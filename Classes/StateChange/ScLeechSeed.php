<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/StateChange.php');

/**
* やどりぎのタネ
*/
class ScLeechSeed extends StateChange
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'やどりぎのタネ';

    /**
    * 状態変化にかかった際のメッセージ
    * @var string
    */
    public const SICKED_MSG = '::pokemonは、やどりぎのタネを植え付けられた';

    /**
    * すでにこの状態変化にかかっている際のメッセージ
    * @var string
    */
    public const SICKED_ALREADY_MSG = '::pokemonは、既にやどりぎのタネを植え付けられている';

    /**
    * ターンチェック時に表示されるメッセージ
    * @var string
    */
    public const TURN_MSG = 'やどりぎのタネが::pokemonの体力を吸収している';

}
