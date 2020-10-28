<?php
require_once($root_path.'/App/Controllers/Evolve/EvolveController.php');
require_once($root_path.'/Resources/Lang/Translation.php');
$controller = new EvolveController();
$responses = $controller->getResponses();
$pokemon = $controller->getPokemon();
$_SESSION['__data']['pokemon'] = $controller->serializeObject($pokemon); # 自ポケモンの情報をセッションに格納
