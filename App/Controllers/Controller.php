<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/AutoLoader.php');
require_once($root_path.'/Classes/Player.php');

// コントローラー
abstract class Controller
{
    /**
    * プレイヤー
    * @var object::Player
    */
    protected $player;

    // /**
    // * サニタイズ後のポストデータ格納用
    // * @var object
    // */
    // private $post;

    /**
    * @return void
    */
    public function __construct()
    {
        // オートローダーの起動
        new AutoLoader;
        // コンストラクタで実行させる処理
        $this->callConstruct();
    }

    /**
    * @return void
    */
    public function __destruct()
    {
        $this->callDestruct();
    }

    /**
    * コンストラクタで呼び出す初期処理
    * @return void
    */
    private function callConstruct()
    {
        if(
            isset($_SESSION['__route']) &&
            $_SESSION['__route'] !== 'initial'
        ){
            // トレーナーの引き継ぎ
            setPlayer(
                unserializeObject($_SESSION['__data']['player'])
            );
        }
        // メッセージIDの重複回避
        if(
            isset($_SESSION['__data']['before_reponses']) ||
            isset($_SESSION['__data']['before_messages']) ||
            isset($_SESSION['__data']['before_modals'])
        ){
            $this->avoidMessageId();
        }
    }

    /**
    * デストラクタとリダイレクトで呼び出す画面移管直前の処理
    * @return void
    */
    private function callDestruct()
    {
        $_POST = [];
        // 初期画面への移管ではなければトレーナーをシリアライズ化
        if(
            !isset($_SESSION['__route']) ||
            $_SESSION['__route'] !== 'initial'
        ){
            $_SESSION['__data']['player'] = serializeObject(player());
        }
    }

    /**
    * 画面移管
    * @return void
    */
    protected function redirect()
    {
        $this->callDestruct();
        // セッションを保存
        session_write_close();
        // リダイレクト
        header("Location: ./", true, 307);
        // 処理終了
        exit;
    }

    /**
    * メッセージIDの重複回避
    *
    * @return void
    */
    private function avoidMessageId()
    {
        // 格納用の空配列
        $results = [];
        // array_fillterコールバック用関数
        function callback($msg_id){
            // 行頭にmsgがついているかを判定
            return preg_match('/^msg/', $msg_id);
        }
        // レスポンス
        if(isset($_SESSION['__data']['before_responses'])){
            $results = array_filter(
                array_keys($_SESSION['__data']['before_responses']),
                'callback'
            );
        }
        // メッセージ
        if(isset($_SESSION['__data']['before_messages'])){
            $msg_ids = array_filter(
                array_column($_SESSION['__data']['before_messages'], 1),
                'callback'
            );
            // 結果の差分を格納
            $results = array_merge($results, array_diff($msg_ids, $results));
        }
        // モーダル
        if(isset($_SESSION['__data']['before_modals'])){
            $msg_ids = array_filter(
                array_column($_SESSION['__data']['before_modals'], 0),
                'callback'
            );
            // 結果の差分を格納
            $results = array_merge($results, array_diff($msg_ids, $results));
        }
        // 重複回避用のメッセージIDに格納
        setUsedMessageId($results);
    }

}
