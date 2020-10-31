<?php
$root_path = __DIR__.'/../../..';
require_once($root_path.'/App/Controllers/Controller.php');
// サービス
require_once($root_path.'/App/Services/Home/RecoveryService.php');

// ホーム用コントローラー
class HomeController extends Controller
{

    /**
    * @return void
    */
    public function __construct()
    {
        // 親コンストラクタの呼び出し
        parent::__construct();
        // 引き継ぎ
        $this->takeOver();
        // 分岐処理
        $this->branch();
        // 親デストラクタの呼び出し
        parent::__destruct();
    }

    /**
    * 引き継ぎ処理
    * @return void
    */
    private function takeOver()
    {
        // ポケモンの引き継ぎ
        $this->pokemon = $this->unserializeObject($_SESSION['__data']['pokemon']);
        // パーティーにセット
        $this->party = $this->unserializeObject($_SESSION['__data']['party']);
    }

    /**
    * アクションに合わせた分岐
    * @return void
    */
    private function branch()
    {
        try {
            switch ($_POST['action'] ?? '') {
                /******************************************
                * リセット
                */
                case 'reset':
                $_SESSION['__route'] = 'initial';
                header("Location: ./", true, 307);
                // exit;
                break;
                /******************************************
                * ポケモンセンター
                */
                case 'recovery':
                $service = new RecoveryService($this->pokemon);
                $service->execute();
                break;
                /******************************************
                * バトル
                */
                case 'battle':
                if($this->pokemon->getRemainingHp() <= 0){
                    setMessage('バトルに参加できるポケモンがいません');
                    break;
                }
                $_SESSION['__route'] = 'battle';
                $_SESSION['__token'] = $_POST['__token'];
                header("Location: ./", true, 307);
                break;
                /******************************************
                * アクション未選択 or 実装されていないアクション
                */
                default:
                break;
            }
        } catch (\Exception $e) {
            // 初期画面へ移管
            $_SESSION['__route'] = 'initial';
            header("Location: ./", true, 307);
            exit;
        }
    }

}
