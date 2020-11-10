<?php
require_once($root_path.'/App/Controllers/Home/HomeController.php');
$controller = new HomeController();
// レスポンスを変数へ格納
$responses = $global_responses->getResponses();
$modals = $global_responses->getModals();
$messages = $global_responses->getMessages();
$player = $controller->getPlayer();
