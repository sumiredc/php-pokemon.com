<?php
require_once($root_path.'/App/Controllers/Evolve/EvolveController.php');
$controller = new EvolveController();
// レスポンスを変数へ格納
$responses = $global_responses->getResponses();
$modals = $global_responses->getModals();
$messages = $global_responses->getMessages();
// ポケモン
$pokemon = $controller->getPokemon();
// セッションへ格納
$_SESSION['__data']['party'] = $controller->serializeObject($controller->getParty());
$_SESSION['__data']['pokemon'] = $controller->serializeObject($pokemon); # 自ポケモンの情報をセッションに格納
