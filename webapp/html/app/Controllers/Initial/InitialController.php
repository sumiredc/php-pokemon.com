<?php
require_once app_path('Controllers/Controller.php');
// サービス
require_once app_path('Services/Initial/SelectPokemonService.php');
require_once app_path('Services/Initial/LoadService.php');

// 初期画面用コントローラー
class InitialController extends Controller
{

    /**
    * @return void
    */
    public function __construct()
    {
        // 親コンストラクタの呼び出し
        parent::__construct();
        // 分岐処理
        $this->branch();
        // 親デストラクタの呼び出し
        parent::__destruct();
    }

    /**
    * アクションに合わせた分岐
    * @return void
    */
    private function branch()
    {
        switch (request('action')) {
            /**
            * ポケモンの選択
            */
            case 'select_pokemon':
            $service = new SelectPokemonService;
            $service->execute();
            // 認証成功
            if($service->auth()){
                // ホーム画面へ移管
                $_SESSION['__route'] = 'home';
                $_SESSION['__start_php_pokemon'] = true;
                // 画面移管
                $this->redirect();
            }
            break;
            /**
            * セーブデータの読み込み
            */
            case 'load':
            $service = new LoadService;
            $service->execute();
            // セーブデータの読み込み成功
            if($service->auth()){
                // ホーム画面へ移管
                $_SESSION['__route'] = 'home';
                $_SESSION['__restart_php_pokemon'] = true;
                // 画面移管
                $this->redirect();
            }
            break;
            /**
            * アクション未選択 or 実装されていないアクション
            */
            default:
            // 初期化
            $_SESSION = [];
            $_SESSION['__token'] = bin2hex(openssl_random_pseudo_bytes(32));
            break;
        }
    }

}
