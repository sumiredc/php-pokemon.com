<?php
require_once app_path('Controllers/Controller.php');
// サービス
require_once app_path('Services/Pokebox/SwitchService.php');
require_once app_path('Services/Pokebox/DepositService.php');
require_once app_path('Services/Pokebox/ReceiveService.php');
require_once app_path('Services/Pokebox/AddBoxService.php');

// ポケモンボックス用コントローラー
class PokeboxController extends Controller
{

    /**
    * @return void
    */
    public function __construct()
    {
        // 親コンストラクタの呼び出し
        parent::__construct();
        // ボックスの起動
        startPokebox();
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
        // ボックスの保存
        savePokebox();
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
            /******************************************
            * ボックスの切り替え
            */
            case 'switch':
            $service = new SwitchService;
            $service->execute();
            break;
            /******************************************
            * ポケモンを預ける
            */
            case 'deposit':
            $service = new DepositService;
            $service->execute();
            break;
            /******************************************
            * ポケモンを引き取る
            */
            case 'receive':
            $service = new ReceiveService;
            $service->execute();
            break;
            /******************************************
            * ボックスの追加
            */
            case 'add_box':
            $service = new AddBoxService;
            $service->execute();
            break;
            /******************************************
            * ボックス終了
            */
            case 'shutdown':
            shutdownPokebox();
            $_SESSION['__route'] = 'home';
            // 画面移管
            $this->redirect();
            break;
            /******************************************
            * アクション未選択・ボックス起動
            */
            default:
            response()->setMessage('ようこそ、ポケモン預かりシステムへ');
            break;
        }
    }

}
