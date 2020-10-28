<?php
require_once($root_path.'/App/Controllers/Battle/BattleController.php');
require_once($root_path.'/Resources/Lang/Translation.php');
$controller = new BattleController();
$pokemon = $controller->getPokemon();
$enemy = $controller->getEnemy();
$before_pokemon = $controller->getBefore($pokemon);
$before_enemy = $controller->getBefore($enemy);
$responses = $controller->getResponses();
// 引き継ぐデータをセッションへ格納
// $_SESSION['__data']['pokemon'] = $pokemon->export(); # 自ポケモンの情報をセッションに格納
// $_SESSION['__data']['enemy'] = $enemy->export(); # 敵ポケモンの情報をセッションに格納
$_SESSION['__data']['pokemon'] = $controller->serializeObject($pokemon);
$_SESSION['__data']['enemy'] = $controller->serializeObject($enemy);
$_SESSION['__data']['run'] = $controller->run; # にげるの実行回数をセッションへ格納
$_SESSION['__data']['field'] = $controller->getField(); # にげるの実行回数をセッションへ格納
// $_SESSION['__data']['rank'] = [ # ランクをセッションに格納
// 'pokemon' => $pokemon->export('rank'),
// 'enemy' => $enemy->export('rank'),
// ];
// $_SESSION['__data']['sc'] = [ # 状態変化をセッションに格納
// 'pokemon' => $pokemon->export('sc'),
// 'enemy' => $enemy->export('sc'),
// ];
// レスポンスデータを引き継ぎ用にセッションへ格納
// レスポンス・モーダルはシリアライズ化
$_SESSION['__data']['before_reponses'] = $controller->serializeObject(
    $controller->getResponses()
);
$_SESSION['__data']['before_modals'] = $controller->serializeObject(
    $controller->getModals()
);
$_SESSION['__data']['before_messages'] = $controller->getMessages();
