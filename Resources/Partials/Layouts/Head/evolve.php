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
// $_SESSION['__data']['party'] = $controller->serializeObject($controller->getParty());
// // レスポンスデータを引き継ぎ用にセッションへ格納
// // レスポンス・モーダルはシリアライズ化
// $_SESSION['__data']['before_reponses'] = $controller->serializeObject($responses);
// $_SESSION['__data']['before_modals'] = $controller->serializeObject($modals);
// $_SESSION['__data']['before_messages'] = $messages;
