<?php
require_once($root_path.'/App/Controllers/Initial/InitialController.php');
$controller = new InitialController();
// レスポンスを変数へ格納
$responses = response()->getResponses();
$messages = response()->getMessages();
