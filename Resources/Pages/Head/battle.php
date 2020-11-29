<?php
require_once($root_path.'/App/Controllers/Battle/BattleController.php');
$controller = new BattleController;
$before_friend = battle_state()->getBefore('friend');
$before_enemy = battle_state()->getBefore('enemy');
// レスポンスを変数へ格納
$responses = response()->getResponses();
$modals = response()->getModals();
$messages = response()->getMessages();
