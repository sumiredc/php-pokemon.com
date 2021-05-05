<?php
/**
* セッション
*/
session_name('YQUAL_PHP_POKEMON_SESSION');
session_save_path(__DIR__.'/storage/sessions');
ini_set('session.gc_maxlifetime', 86400);
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 50);
session_start();
session_regenerate_id(true);

// タイムゾーン
date_default_timezone_set('Asia/Tokyo');

/**
* ルーティング
*/
require_once __DIR__.'/app/Classes/Route.php';
Route::auth();

/**
* トークン発行
*/
$_SESSION['__token'] = bin2hex(openssl_random_pseudo_bytes(32));

/**
* グローバル関数
*/
require_once __DIR__.'/app/Globals/ConfigGlobal.php';
require_once __DIR__.'/app/Globals/PathGlobal.php';
require_once __DIR__.'/app/Globals/ImageGlobal.php';
require_once __DIR__.'/app/Globals/RequestGlobal.php';
require_once __DIR__.'/app/Globals/ResponseGlobal.php';
require_once __DIR__.'/app/Globals/SerializeGlobal.php';
require_once __DIR__.'/app/Globals/CommonGlobal.php';
require_once __DIR__.'/app/Globals/PlayerGlobal.php';
require_once __DIR__.'/app/Globals/PokeboxGlobal.php';
// バトル画面専用のグローバル関数
if(getPageName() === 'battle'){
    require_once __DIR__.'/app/Globals/BattleStateGlobal.php';
}

/**
* 環境変数
*/

// メンテナンスモード
if(env(503)){
    include __DIR__.'/public/503.php';
    exit;
}

/**
* コントローラの読み込み
*/
require_once __DIR__.Route::controller('path');
$controller_class = Route::controller('class');
$controller = new $controller_class;

/**
* テンプレートの読み込み
*/
require_once __DIR__.Route::template();

/**
* ページ読み込み後に行う処理
*/
response()->setWaitForceModal(); # 待機中の強制モーダルを次ページ用に格納
