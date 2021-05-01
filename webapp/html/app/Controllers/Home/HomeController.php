<?php
require_once app_path('Controllers/Controller.php');
// サービス
require_once app_path('Services/Home/ReportService.php');
require_once app_path('Services/Home/ItemService.php');
require_once app_path('Services/Home/RecoveryService.php');
require_once app_path('Services/Home/ShopService.php');
require_once app_path('Services/Home/SortPartyService.php');
require_once app_path('Services/Home/LearnMoveService.php');
// トレイト
require_once app_path('Traits/Controller/HomeControllerTrait.php');

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
        // プレイヤー情報の最終更新日時を更新
        player()->setUpdatedAt();
    }

    /**
    * @return void
    */
    public function __destruct()
    {
        $_SESSION['__data']['before_responses'] = serializeObject(response()->responses());
        $_SESSION['__data']['before_modals'] = serializeObject(response()->modals());
        $_SESSION['__data']['before_messages'] = response()->messages();
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
                * レポート
                */
                case 'report':
                $service = new ReportService;
                $service->execute();
                break;
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
                // アクション有り
                if(response()->getResponse('action')){
                    $_SESSION['__route'] = response()->getResponse('action');
                    // 画面移管
                    $this->redirect();
                }
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
                * トレーナー戦
                */
                case 'battle_trainer':
                // バトル開始可能な状態かを確認
                if($this->validationBattleTrainer()){
                    $_SESSION['__route'] = 'battle';
                    // バトルコントローラーへaction値をpostするためにトークンをセット
                    $_SESSION['__token'] = $_POST['__token'];
                    // 画面移管
                    $this->redirect();
                }
                break;
				/******************************************
                * ジム戦
                */
                case 'battle_leader':
                // バトル開始可能な状態かを確認
                if($this->validationBattleLeader()){
                    $_SESSION['__route'] = 'battle';
                    // バトルコントローラーへaction値をpostするためにトークンをセット
                    $_SESSION['__token'] = $_POST['__token'];
                    // 画面移管
                    $this->redirect();
                }
                break;
                /******************************************
                * 技の習得
                */
                case 'learn_move':
                // サービス実行
                $service = new LearnMoveService(
                    $_SESSION['__data']['before_responses'],
                    $_SESSION['__data']['before_messages'],
                    $_SESSION['__data']['before_modals']
                );
                $service->execute();
                break;
                /******************************************
                * アクション未選択 or 実装されていないアクション
                */
                default:
                // ゲーム開始時のメッセージをセット
                if(isset($_SESSION['__start_php_pokemon'])){
                    response()->setMessage('ようこそ！PHPポケモンの世界へ', null, 'info');
                    unset($_SESSION['__start_php_pokemon']);
                }
                if(isset($_SESSION['__restart_php_pokemon'])){
                    response()->setMessage('おかえりなさい、'.player()->getName().'様', null, 'info');
                    unset($_SESSION['__restart_php_pokemon']);
                }
                break;
            }
        } catch (Exception $ex) {
            // ホーム画面へ移管
            $_SESSION['__route'] = 'home';
            // 画面移管
            $this->redirect();
        }
    }

}
