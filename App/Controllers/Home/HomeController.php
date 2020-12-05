<?php
require_once(app_path('Controllers').'Controller.php');
// サービス
require_once(app_path('Services.Home').'ItemService.php');
require_once(app_path('Services.Home').'RecoveryService.php');
require_once(app_path('Services.Home').'ShopService.php');
require_once(app_path('Services.Home').'SortPartyService.php');
// トレイト
require_once(app_path('Traits.Controller').'HomeControllerTrait.php');

// ホーム用コントローラー
class HomeController extends Controller
{

    use HomeControllerTrait;

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
    * @return void
    */
    public function __destruct()
    {
        // 親デストラクタの呼び出し
        parent::__destruct();
    }

    /**
    * アクションに合わせた分岐
    * @return void
    */
    private function branch()
    {
        try {
            switch (request('action')) {
                /******************************************
                * リセット
                */
                case 'reset':
                $_SESSION['__route'] = 'initial';
                // 画面移管
                $this->redirect();
                break;
                /******************************************
                * どうぐ
                */
                case 'item':
                $service = new ItemService;
                $service->execute();
                break;
                /******************************************
                * 回復
                */
                case 'recovery':
                $service = new RecoveryService;
                $service->execute();
                break;
                /******************************************
                * ポケモンボックス
                */
                case 'pokebox':
                $_SESSION['__route'] = 'pokebox';
                // 画面移管
                $this->redirect();
                break;
                /******************************************
                * フレンドリィショップ
                */
                case 'shop':
                $service = new ShopService;
                $service->execute();
                break;
                /******************************************
                * ポケモンの並び替え
                */
                case 'sort_party':
                $service = new SortPartyService;
                $service->execute();
                break;
                /******************************************
                * フィールドへ
                */
                case 'battle':
                // バトル開始可能な状態かを確認
                if($this->validationBattle()){
                    $_SESSION['__route'] = 'battle';
                    // バトルコントローラーへaction値をpostするためにトークンをセット
                    $_SESSION['__token'] = $_POST['__token'];
                    // 画面移管
                    $this->redirect();
                }
                break;
                /******************************************
                * アクション未選択 or 実装されていないアクション
                */
                default:
                // ゲーム開始時のメッセージをセット
                if(isset($_SESSION['__start_php_pokemon'])){
                    response()->setMessage('ようこそ！PHPポケモンの世界へ');
                    unset($_SESSION['__start_php_pokemon']);
                }
                break;
            }
        } catch (Exception $ex) {
            // 初期画面へ移管
            $_SESSION['__route'] = 'initial';
            // 画面移管
            $this->redirect();
        }
    }

}
