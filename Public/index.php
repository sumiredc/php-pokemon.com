<?php
$root_path = __DIR__.'/..';
/**
* セッションスタート
*/
session_save_path($root_path.'/Storage/Sessions');
ini_set('session.gc_maxlifetime', 86400);
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 50);
session_start();
session_regenerate_id(true);
/**
* ルーティング
*/
require_once($root_path.'/Classes/Route.php');
$route = new Route($_SESSION['__route'] ?? 'initial', $_SESSION['__token'] ?? '');

/**
* トークン発行
*/
$_SESSION['__token'] = bin2hex(openssl_random_pseudo_bytes(32));

/**
* 共通関数
*/
function input_token(){
    echo '<input type="hidden" name="__token" value="'.$_SESSION['__token'].'">';
}

/**
* ページテンプレートの読み込み
*/
require_once($root_path.$route->template());
?>
