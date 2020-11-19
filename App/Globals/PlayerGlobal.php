<?php
$global_player = null;
// クラス読み込み
require_once($root_path.'/Classes/Player.php');

/**
* プレイヤーの初期化
* @param name:string
* @return void
*/
function initPlayer(string $name)
{
    global $global_player;
    $global_player = new Player($name);
}
/**

* プレイヤーの格納
* @param player:object::Player
* @return void
*/
function setPlayer($player)
{
    global $global_player;
    $global_player = $player;
}

/**
* プレイヤーの取得
* @return object::Player
*/
function player()
{
    global $global_player;
    return $global_player;
}
