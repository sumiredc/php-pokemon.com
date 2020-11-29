<?php
require_once($root_path.'/App/Controllers/Home/HomeController.php');
$controller = new HomeController();
// レスポンスを変数へ格納
$responses = response()->getResponses();
$modals = response()->getModals();
$messages = response()->getMessages();
