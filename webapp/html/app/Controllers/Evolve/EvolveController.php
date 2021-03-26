<?php
require_once app_path('Controllers/Controller.php');
// サービス
require_once app_path('Services/Evolve/EvolveService.php');
require_once app_path('Services/Evolve/CancelService.php');
require_once app_path('Services/Evolve/DefaultService.php');
require_once app_path('Services/Evolve/LearnMoveService.php');
// トレイト
require_once app_path('Traits/Controller/EvolveControllerTrait.php');

// 進化画面用コントローラー
class EvolveController extends Controller
{

    use EvolveControllerTrait;

    /**
    * @return void
    */
    protected $process_flg = false;

    /**
    * @return void
    */
    public function __construct()
    {
        // 親コンストラクタの呼び出し
        parent::__construct();
        // 引き継ぎ
        $this->inheritance();
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
        $_SESSION['__data']['before_responses'] = serializeObject(response()->responses());
        $_SESSION['__data']['before_modals'] = serializeObject(response()->modals());
        $_SESSION['__data']['before_messages'] = response()->messages();
        if($this->process_flg){
            $_SESSION['__data']['order'] = $this->order;
        }
        // 親デストラクタの呼び出し
        parent::__destruct();
    }

    /**
    * アクションに合わせた分岐
    * @return void
    */
    private function branch()
    {
        // 対象がいなければホーム画面へ移管
        if(is_null($this->order)){
            $this->goToHome();
        }
        // アクションに合わせた分岐
        switch (request('action')) {
            /******************************************
            * 進化
            */
            case 'evolve':
            $service = new EvolveService($this->order);
            $service->execute();
            // 処理中フラグを引き継ぎ
            $this->process_flg = $service->process_flg;
            break;
            /******************************************
            * 進化キャンセル
            */
            case 'cancel':
            $service = new CancelService($this->order);
            $service->execute();
            // ページをリロード
            $this->reload();
            break;
            /******************************************
            * 技の習得
            */
            case 'learn_move':
            // サービス実行
            $service = new LearnMoveService(
                $this->order,
                $_SESSION['__data']['before_responses'],
                $_SESSION['__data']['before_messages'],
                $_SESSION['__data']['before_modals']
            );
            $service->execute();
            break;
            /******************************************
            * 進化確認画面
            */
            default:
            $service = new DefaultService($this->order);
            $service->execute();
            break;
        }

    }

    /**
    * ホーム画面へ移管させる処理
    * @return void
    */
    protected function goToHome()
    {
        unset(
            $_SESSION['__data']['order'],
            $_SESSION['__data']['before_messages'],
            $_SESSION['__data']['before_modals'],
            $_SESSION['__data']['before_responses']
        );
        $_SESSION['__route'] = 'home';
        // 画面移管
        $this->redirect();
    }

    /**
    * リロード処理
    * @return void
    */
    protected function reload()
    {
        unset(
            $_SESSION['__data']['order'],
            $_SESSION['__data']['before_messages'],
            $_SESSION['__data']['before_modals'],
            $_SESSION['__data']['before_responses']
        );
        $_SESSION['__route'] = 'evolve';
        // 画面移管
        $this->redirect();
    }

}
