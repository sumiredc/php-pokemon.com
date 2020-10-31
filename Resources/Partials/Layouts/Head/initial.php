<?php
require_once($root_path.'/App/Controllers/Initial/InitialController.php');
$controller = new InitialController();
// レスポンスを変数へ格納
$responses = $global_responses->getResponses();
$messages = $global_responses->getMessages();
