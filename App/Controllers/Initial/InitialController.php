<?php
$root_path = __DIR__.'/../../..';
require_once($root_path.'/App/Controllers/Controller.php');
// サービス
require_once($root_path.'/App/Services/Initial/SelectPokemonService.php');

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
