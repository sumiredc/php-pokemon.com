<?php
require_once($root_path.'/App/Controllers/Evolve/EvolveController.php');
$controller = new EvolveController();
// レスポンスを変数へ格納
$responses = response()->getResponses();
$modals = response()->getModals();
$messages = response()->getMessages();
// ポケモン
$pokemon = $controller->getPokemon();
