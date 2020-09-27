<?php
require_once(__DIR__.'/../StateChange.php');

// やどりぎのタネ
class ScLeechSeed extends StateChange
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'やどりぎのタネ';

    /**
    * 状態変化にかかった際のメッセージ
    * @var string
    */
    protected $sicked_msg = '::pokemonは、混乱した';

    /**
    * すでにこの状態変化にかかっている際のメッセージ
    * @var string
    */
    protected $sicked_already_msg = '::pokemonは、既にやどりぎのタネを植え付けられている';

    /**
    * ターンチェック時に表示されるメッセージ
    * @var string
    */
    protected $turn_msg = 'やどりぎのタネが::pokemonの体力を吸収している';

}