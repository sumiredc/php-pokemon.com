<?php
global $test_message;
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/AutoLoader.php');
require_once($root_path.'/Classes/Sanitize.php');
// トレイト
// require_once($root_path.'/App/Traits/ResponseTrait.php');
require_once($root_path.'/App/Traits/InstanceTrait.php');
require_once($root_path.'/App/Traits/SerializeTrait.php');

// コントローラー
abstract class Controller
{
    // use ResponseTrait;
    use InstanceTrait;
    use SerializeTrait;

    /**
    * パーティー
    * @var array
    */
    protected $party = [];

    /**
    * サニタイズ後のポストデータ格納用
    * @var object
    */
    private $post;

    /**
    * @return void
    */
    public function __construct()
    {
        // オートローダーの起動
        new AutoLoader;
        // サニタイズ
        $sanitize = new Sanitize;
        $this->post = $sanitize->getPost();
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
    * @return void
    */
    public function __destruct()
    {
        $_POST = [];
    }

    /**
    * 画面移管
    * @return void
    */
    protected function redirect()
    {
        // 初期画面への移管ではなければパーティーを再セット
        if($_SESSION['__route'] !== 'initial'){
            $_SESSION['__data']['party'] = serializeObject($this->party);
        }
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

    /**
    * パーティーの取得
    *
    * @return array
    */
    public function getParty()
    {
        return $this->party;
    }

    /**
    * リクエストデータの取得
    *
    * @param string
    * @return mixed
    */
    public function request($key='')
    {
        if(empty($key)){
            return $this->post;
        }else{
            return $this->post[$key] ?? '';
        }
    }

}
