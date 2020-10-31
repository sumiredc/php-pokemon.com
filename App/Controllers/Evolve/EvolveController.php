<?php
$root_path = __DIR__.'/../../..';
require_once($root_path.'/App/Controllers/Controller.php');

// 進化画面用コントローラー
class EvolveController extends Controller
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
        $this->party = $this->unserializeObject($_SESSION['__data']['party']);
        $this->pokemon = $this->unserializeObject($_SESSION['__data']['pokemon']);
    }

    /**
    * アクションに合わせた分岐
    * @return void
    */
    private function branch()
    {
        // 進化処理が終わっていればホーム画面へ移管
        if(!$this->pokemon->getEvolveFlg()){
            $this->goToHome();
        }
        switch ($_POST['action'] ?? '') {
            /******************************************
            * 進化
            */
            case 'evolve':
            $this->pokemon = $this->pokemon
            ->evolve();
            break;
            /******************************************
            * 進化キャンセル
            */
            case 'cancel':
            // 進化フラグをfalseにする
            $this->pokemon
            ->setEvolveFlgFalse();
            $_SESSION['__data']['pokemon'] = $this->serializeObject($this->pokemon);
            $this->goToHome();
            break;
            /******************************************
            * 進化確認画面(初期)
            */
            default:
            // 確認メッセージ
            $msg_id1 = issueMsgId();
            setMessage('・・・おや！？ '.$this->pokemon->getNickName().'の様子が・・・！');
            setAutoMessage($msg_id1);
            setResponse([
                'action' => 'evolve'
            ], $msg_id1);
            // 終了メッセージ
            $msg_id2 = issueMsgId();
            setMessage('あれ・・・？ '.$this->pokemon->getNickName().'の変化が止まった！', $msg_id2);
            setResponse([
                'action' => 'cancel'
            ], $msg_id2);
            break;
        }
        setEmptyMessage();
    }

    /**
    * ホーム画面へ移管させる処理
    * @return void
    */
    private function goToHome()
    {
        $_SESSION['__route'] = 'home';
        header("Location: ./", true, 307);
    }

}
