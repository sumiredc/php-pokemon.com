<?php
require_once($root_path.'/App/Controllers/Battle/BattleController.php');
$controller = new BattleController;
$pokemon = $controller->getPokemon();
$enemy = $controller->getEnemy();
$before_pokemon = $controller->getBefore($pokemon);
$before_enemy = $controller->getBefore($enemy);
$battle_state = getBattleState();
// レスポンスを変数へ格納
$responses = getResponses();
$modals = getModals();
$messages = getMessages();
