<?php
require_once(__DIR__.'/../StateChange.php');

// ひるみ
class ScFlinch extends StateChange
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'ひるみ';

    /**
    * 状態変化にかかった際のメッセージ
    * @var string
    */
    protected $sicked_msg = '::pokemonは、ひるんだ';

}
