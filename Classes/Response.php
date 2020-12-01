<?php
class Response
{
    /**
    * 使用中のメッセージID格納用
    * @var array
    */
    private $message_ids = [];

    /**
    * メッセージの格納用
    * @var array
    */
    private $messages = [];

    /**
    * レスポンスデータの格納用
    * @var array
    */
    private $responses = [];

    /**
    * モーダルの格納用
    * @var array
    */
    private $modals = [];

    /**
    * 待機中の強制表示モーダルID
    * @var string
    */
    private $wait_force_modal = '';

    /**
    * メッセージIDの発行
    * @return string
    */
    public function issueMsgId()
    {
        // IDを生成
        $id = 'msg'.substr(bin2hex(random_bytes(16)), 0, 16);
        // ユニークになるようにチェック
        while(in_array($id, $this->message_ids ?? [], true)){
            $id = 'msg'.substr(bin2hex(random_bytes(16)), 0, 16);
        }
        $this->message_ids[] = $id;
        return $id;
    }

    /**
    * 使用中のメッセージIDを格納
    * @return string
    */
    public function setUsedMessageId($arg)
    {
        if(is_array($arg)){
            $this->message_ids = array_merge($this->message_ids, $arg);
        }else{
            $this->message_ids[] = $arg;
        }
    }

    /**
    * 全リセット
    * @return void
    */
    public function resetResponsesAll()
    {
        $this->messages = [];
        $this->responses = [];
        $this->modals = [];
    }

    /**==================================================================
    * ヘルパーメソッド
    ==================================================================**/

    /**
    * レスポンスの取得
    * @return array
    */
    public function responses(): array
    {
        return $this->responses;
    }

    /**
    * メッセージの取得
    * @return array
    */
    public function messages(): array
    {
        return $this->messages;
    }

    /**
    * モーダルの取得
    * @return array
    */
    public function modals(): array
    {
        return $this->modals;
    }

    /**==================================================================
    * メッセージ関係の処理
    ==================================================================**/
    /**
    * メッセージの取得
    *
    * @return array
    */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
    * メッセージの格納
    *
    * @param string|array $msg
    * @param mixed $param
    * @return array
    */
    public function setMessage($msg, $param=null)
    {
        if(empty($msg)){
            // 空の場合はスキップ
            return;
        }
        if(is_array($msg)){
            $messages = array_map(function($message){
                // 要素が配列でなければ、メッセージ用配列形式に変換して返却
                if(!is_array($message)){
                    $message = [$message, '', ''];
                }
                return $message;
            }, $msg);
            // 一括登録
            $this->messages = array_merge($this->messages, $messages);
        }else{
            // 単発登録
            $this->messages[] = [$msg, $param, ''];
        }
    }

    /**
    * アニメーション用の自動メッセージの格納
    *
    * @param mixed $param
    * @return array
    */
    public function setAutoMessage($param='')
    {
        $this->messages[] = ['', $param, 'auto'];
    }

    /**
    * 空メッセージの格納
    *
    * @param string $param
    * @return array
    */
    public function setEmptyMessage(string $param='')
    {
        $this->messages[] = ['', $param, ''];
    }

    /**
    * メッセージの初期化
    *
    * @return void
    */
    public function resetMessage()
    {
        $this->messages = [];
    }

    /**
    * メッセージの最初のキーを取得
    *
    * @return void
    */
    public function getMessageFirstKey()
    {
        return array_key_first($this->messages);
    }

    /**
    * メッセージの最後のキーを取得
    *
    * @return void
    */
    public function getMessageLastKey()
    {
        return array_key_last($this->messages);
    }

    /**==================================================================
    * レスポンス関係の処理
    ==================================================================**/
    /**
    * 指定したレスポンステータの取得
    *
    * @param string|integer
    * @return mixed
    */
    public function getResponse($param)
    {
        if(isset($this->responses[$param])){
            return $this->responses[$param];
        }
    }

    /**
    * レスポンステータの全取得
    *
    * @return array
    */
    public function getResponses()
    {
        return $this->responses;
    }

    /**
    * レスポンステータの格納
    *
    * @param mixed $response
    * @param mixed $key
    * @return array
    */
    public function setResponse($response, $key=null)
    {
        if(empty($response)){
            // 空の場合はスキップ
            return;
        }
        if(is_null($key)){
            // キー指定無し
            if(is_array($response)){
                // $responseが配列の場合の処理
                $this->responses = array_merge($this->responses, $response);
            }else{
                // $responseが配列ではない場合の処理
                $this->responses[] = $response;
            }
        }else{
            // キー指定有り
            $this->responses[$key] = $response;
        }
    }

    /**
    * 指定されたプロパティをレスポンスにセット(出力)
    *
    * @return void
    */
    public function exportProperty(...$properties)
    {
        foreach($properties as $property){
            $this->setResponse($this->$property, $property);
        }
    }

    /**
    * レスポンステータの初期化
    *
    * @return void
    */
    public function resetResponse()
    {
        $this->responses = [];
    }

    /**==================================================================
    * モーダル関係の処理
    ==================================================================**/
    /**
    * モーダルテータの取得
    *
    * @return array
    */
    public function getModals()
    {
        return $this->modals;
    }

    /**
    * モーダル用テータの格納
    * @param param:array
    * @param merge:boolean
    * @return void
    */
    public function setModal(array $param, bool $merge=false): void
    {
        if(empty($param)){
            // 空の場合はスキップ
            return;
        }
        if($merge){
            // 結合（引き継ぎ）
            $this->modals = array_merge($this->modals, $param);
        }else{
            // モーダル格納
            $this->modals[] = $param;
            // モーダルが最終になる場合を想定した空の自動メッセージをセット
            $this->setAutoMessage();
        }
    }

    /**
    * モーダル情報の初期化
    *
    * @return void
    */
    public function resetModal()
    {
        $this->modals = [];
    }

    /**
    * 強制表示モーダルの初期化
    * @return void
    */
    public function initForceModal(): void
    {
        unset($_SESSION['__data']['force_modal']);
    }

    /**
    * 強制表示モーダルのセット
    * @param id:string
    * @return boolean
    */
    public function setForceModal($id): bool
    {
        // 強制表示させるモーダルを取得
        $key = array_search($id, array_column($this->modals, 'id'));
        // 見つかればセッションへ格納
        if($key !== false){
            $_SESSION['__data']['force_modal'] = $this->modals[$key];
            // ID重複回避のためモーダル内から取り除く
            unset($this->modals[$key]);
            return true;
        }
        return false;
    }

    /**
    * 強制表示モーダルを待機状態にする（更新等された際に強制表示）
    * @param id:string
    * @return void
    */
    public function waitForceModal($id): void
    {
        $this->wait_force_modal = $id;
    }

    /**
    * 強制表示モーダルを待機状態にする（更新等された際に強制表示）
    * @param id:string
    * @return boolean
    */
    public function setWaitForceModal(): bool
    {
        // 待機中の強制表示モーダルがあれば、セッションへ格納
        if($this->wait_force_modal){
            $this->setForceModal($this->wait_force_modal);
            $this->wait_force_modal = '';
            return true;
        }
        // 待機中なし
        return false;
    }

    /**
    * 強制表示モーダルの存在確認
    * @return boolean
    */
    public function isForceModal(): bool
    {
        if(isset($_SESSION['__data']['force_modal'])){
            return true;
        }
        return false;
    }

    /**
    * 強制表示モーダルの取得
    * @return array
    */
    public function getForceModal(): array
    {
        return $_SESSION['__data']['force_modal'] ?? [];
    }

    /**
    * 強制表示モーダルの確認
    * @return boolean
    */
    public function isForceModalTarget($target): bool
    {
        if(
            isset($_SESSION['__data']['force_modal']['existing_modal']) &&
            $_SESSION['__data']['force_modal']['existing_modal'] === $target
        ){
            return true;
        }
        return false;
    }

}
