<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/StateChange.php');

// こんらん
class ScConfusion extends StateChange
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'こんらん';

    /**
    * 状態変化にかかった際のメッセージ
    * @var string
    */
    protected $sicked_msg = '::pokemonは、混乱した';

    /**
    * すでにこの状態変化にかかっている際のメッセージ
    * @var string
    */
    protected $sicked_already_msg = '::pokemonは、既に混乱している';

    /**
    * ターンチェック時に表示されるメッセージ
    * @var string
    */
    protected $turn_msg = '::pokemonは、こんらんしている';

    /**
    * 行動失敗
    * @var string
    */
    protected $false_msg = '::pokemonは、わけも分からず自分を攻撃した';

    /**
    * 回復時に表示されるメッセージ
    * @var string
    */
    protected $recovery_msg = '::pokemonはこんらんが解けた';

}
