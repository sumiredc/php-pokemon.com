<?php
require_once($root_path.'/App/Controllers/Battle/BattleController.php');
$controller = new BattleController;
$before_pokemon = battle_state()->getBefore('friend');
$before_enemy = battle_state()->getBefore('enemy');
// レスポンスを変数へ格納
$responses = getResponses();
$modals = getModals();
$messages = getMessages();
