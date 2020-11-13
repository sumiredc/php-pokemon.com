<?php
$global_battle_state = null;
// クラス読み込み
require_once($root_path.'/Classes/BattleState.php');
/**
* バトル状態の初期化
* @return void
*/
function initBattleState()
{
    global $global_battle_state;
    $global_battle_state = new BattleState;
}
/**
* バトル状態の格納
* @param battle_state:object::BattleState
* @return void
*/
function setBattleState($battle_state)
{
    global $global_battle_state;
    $global_battle_state = $battle_state;
}
/**
* バトル状態の取得
* @return object::BattleState
*/
function getBattleState()
{
    global $global_battle_state;
    return $global_battle_state;
}
