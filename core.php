<?php
/**
* セッションスタート
*/
session_save_path(__DIR__.'/Storage/Sessions');
ini_set('session.gc_maxlifetime', 86400);
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 50);
session_start();
session_regenerate_id(true);

/**
* ルーティング
*/
require_once(__DIR__.'/Classes/Route.php');
$route = new Route($_SESSION['__route'] ?? 'initial', $_SESSION['__token'] ?? '');

/**
* トークン発行
*/
$_SESSION['__token'] = bin2hex(openssl_random_pseudo_bytes(32));

/**
* グローバル関数
*/
require_once(__DIR__.'/App/Globals/RequestGlobal.php');
require_once(__DIR__.'/App/Globals/ResponseGlobal.php');
require_once(__DIR__.'/App/Globals/ConfigGlobal.php');
require_once(__DIR__.'/App/Globals/SerializeGlobal.php');
require_once(__DIR__.'/App/Globals/FormGlobal.php');
require_once(__DIR__.'/App/Globals/CommonGlobal.php');
require_once(__DIR__.'/App/Globals/PlayerGlobal.php');
// バトル画面専用のグローバル関数
if(getPageName() === 'battle'){
    require_once(__DIR__.'/App/Globals/BattleStateGlobal.php');
}

/**
* ページテンプレートの読み込み
*/
require_once($root_path.'/Resources/Pages/Head/'.getPageName().'.php');
require_once(__DIR__.$route->template());
