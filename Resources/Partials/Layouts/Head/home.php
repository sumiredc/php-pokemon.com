<?php
require_once($root_path.'/App/Controllers/Home/HomeController.php');
require_once($root_path.'/Resources/Lang/Translation.php');
$controller = new HomeController();
$pokemon = $controller->getPokemon();
$_SESSION['__data']['pokemon'] = $pokemon->export(); # ポケモンの情報をセッションに格納
