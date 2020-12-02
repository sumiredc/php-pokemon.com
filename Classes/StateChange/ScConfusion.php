<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/StateChange.php');

/**
* こんらん
*/
class ScConfusion extends StateChange
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'こんらん';

    /**
    * 状態変化にかかった際のメッセージ
    * @var string
    */
    public const SICKED_MSG = '::pokemonは、混乱した';

    /**
    * すでにこの状態変化にかかっている際のメッセージ
    * @var string
    */
    public const SICKED_ALREADY_MSG = '::pokemonは、既に混乱している';

    /**
    * ターンチェック時に表示されるメッセージ
    * @var string
    */
    public const TURN_MSG = '::pokemonは、こんらんしている';

    /**
    * 行動失敗
    * @var string
    */
    public const FAILED_MSG = '::pokemonは、わけも分からず自分を攻撃した';

    /**
    * 回復時に表示されるメッセージ
    * @var string
    */
    public const RECOVERY_MSG = '::pokemonはこんらんが解けた';

}
