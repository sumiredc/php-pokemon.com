<?php
$root_path = __DIR__.'/../../..';
require_once($root_path.'/App/Controllers/Controller.php');
// サービス
require_once($root_path.'/App/Services/Home/RecoveryService.php');
// トレイト
require_once($root_path.'/App/Traits/Controller/HomeControllerTrait.php');

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
        // 次画面へ送るデータ
        // $_SESSION['__data']['party'] = serializeObject($this->party);
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
            switch ($_POST['action'] ?? '') {
                /******************************************
                * リセット
                */
                case 'reset':
                $_SESSION['__route'] = 'initial';
                // 画面移管
                $this->redirect();
                break;
                /******************************************
                * ポケモンセンター
                */
                case 'recovery':
                $service = new RecoveryService($this->party);
                $service->execute();
                break;
                /******************************************
                * バトル
                */
                case 'battle':
                $order = $this->getFightPokemonOrder();
                if(is_null($order)){
                    setMessage('バトルに参加できるポケモンがいません');
                    break;
                }
                $_SESSION['__data']['order'] = $order;
                $_SESSION['__route'] = 'battle';
                $_SESSION['__token'] = $_POST['__token'];
                // 画面移管
                $this->redirect();
                break;
                /******************************************
                * アクション未選択 or 実装されていないアクション
                */
                default:
                break;
            }
        } catch (\Exception $ex) {
            // 初期画面へ移管
            $_SESSION['__route'] = 'initial';
            // 画面移管
            $this->redirect();
        }
    }

}
