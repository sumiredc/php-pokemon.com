<?php
require_once($root_path.'/App/Controllers/Battle/BattleController.php');
$controller = new BattleController();
$pokemon = $controller->getPokemon();
$enemy = $controller->getEnemy();
$before_pokemon = $controller->getBefore($pokemon);
$before_enemy = $controller->getBefore($enemy);
// レスポンスを変数へ格納
$responses = $global_responses->getResponses();
$modals = $global_responses->getModals();
$messages = $global_responses->getMessages();
// 引き継ぐデータをセッションへ格納
$_SESSION['__data']['party'] = $controller->serializeObject($controller->getParty());
$_SESSION['__data']['enemy'] = $controller->serializeObject($enemy);
$_SESSION['__data']['run'] = $controller->run; # にげるの実行回数をセッションへ格納
$_SESSION['__data']['field'] = $controller->getField(); # にげるの実行回数をセッションへ格納
// レスポンスデータを引き継ぎ用にセッションへ格納
// レスポンス・モーダルはシリアライズ化
$_SESSION['__data']['before_reponses'] = $controller->serializeObject($responses);
$_SESSION['__data']['before_modals'] = $controller->serializeObject($modals);
$_SESSION['__data']['before_messages'] = $messages;
