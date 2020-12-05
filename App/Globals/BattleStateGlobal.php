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
function battle_state()
{
    global $global_battle_state;
    return $global_battle_state;
}

/**
* 味方ポケモン情報の取得
* @return mixed
*/
function friend(string $const='')
{
    global $global_battle_state;
    if($const){
        // 指定された定数を返却
        return constant(get_class($global_battle_state->getFriend()).'::'.$const);
    }else{
        // 味方ポケモンのオブジェクトを返却
        return $global_battle_state->getFriend();
    }
}

/**
* 敵ポケモンの取得
* @return mixed
*/
function enemy(string $const='')
{
    global $global_battle_state;
    if($const){
        // 指定された定数を返却
        return constant(get_class($global_battle_state->getEnemy()).'::'.$const);
    }else{
        // 味方ポケモンのオブジェクトを返却
        return $global_battle_state->getEnemy();
    }
}
