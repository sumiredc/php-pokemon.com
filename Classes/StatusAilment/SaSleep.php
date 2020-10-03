<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/StatusAilment.php');

// ねむり
class SaSleep extends StatusAilment
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'ねむり';

    /**
    * 状態異常にかかった際のメッセージ
    * @var string
    */
    protected $sicked_msg = '::pokemonは、眠ってしまった';

    /**
    * すでにこの状態異常にかかっている際のメッセージ
    * @var string
    */
    protected $sicked_already_msg = '::pokemonは、既に眠っている';

    /**
    * 行動失敗時に表示されるメッセージ
    * @var string
    */
    protected $false_msg = '::pokemonは、ぐうぐう眠っている';

    /**
    * 回復時に表示されるメッセージ
    * @var string
    */
    protected $recovery_msg = '::pokemonは、目を覚ました';

}
