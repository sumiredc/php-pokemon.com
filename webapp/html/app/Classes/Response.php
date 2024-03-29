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
    * トーストメッセージの格納用
    * @var array
    */
    private $toastrs = [];

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
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
    * メッセージの格納
    * @param msg:string|array
    * @param param:mixed
    * @param toastr:string::info|error|success|warning
    * @return this
    */
    public function setMessage($msg, $param=null, $toastr=''): Response
    {
        if(empty($msg)){
            // 空の場合はスキップ
            return $this;
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
            // トーストへの登録
            if(in_array($toastr, ['info', 'error', 'success', 'warning'], true)){
                $this->toastrs[] = [$toastr, $msg];
            }
        }
		return $this;
    }

    /**
    * アニメーション用の自動メッセージの格納
    *
    * @param mixed $param
    * @return this
    */
    public function setAutoMessage($param=''): Response
    {
        $this->messages[] = ['', $param, 'auto'];
		return $this;
    }

    /**
    * 空メッセージの格納
    *
    * @param string $param
    * @return this
    */
    public function setEmptyMessage(string $param=''): Response
    {
        $this->messages[] = ['', $param, ''];
		return $this;
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
    * メッセージの初期化
    * @return this
    */
    public function initMessage(): Response
    {
        $this->messages = [];
		return $this;
    }

    /**
    * メッセージの最初のキーを取得
    *
    * @return mixed
    */
    public function getMessageFirstKey()
    {
        return array_key_first($this->messages);
    }

    /**
    * メッセージの最後のキーを取得
    *
    * @return mixed
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
        return $this->responses[$param] ?? null;
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
    * @return this
    */
    public function setResponse($response, $key=null): Response
    {
        if(empty($response)){
            // 空の場合はスキップ
            return $this;
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
		return $this;
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
    * @return void
    */
    public function resetResponse()
    {
        $this->responses = [];
    }

    /**
    * レスポンステータの初期化
    * @return void
    */
    public function initResponse()
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
    * @return this
    */
    public function setModal(array $param, bool $merge=false): Response
    {
        if(empty($param)){
            // 空の場合はスキップ
            return $this;
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
		return $this;
    }

    /**
    * モーダル情報の初期化
    * @return void
    */
    public function resetModal()
    {
        $this->modals = [];
    }

    /**
    * モーダル情報の初期化
    * @return void
    */
    public function initModal()
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

    /**==================================================================
    * トースト関係の処理
    ==================================================================**/

    /**
    * トーストの登録
    * @param design:string
    * @param msg:string::info|error|success|warning
    * @return this
    */
    public function setToastr(string $design, string $msg): Response
    {
        // トーストへの登録
        if(in_array($design, ['info', 'error', 'success', 'warning'], true)){
            $this->toastrs[] = [$design, $msg];
        }
		return $this;
    }

    /**
    * トーストの取得
    * @return array
    */
    public function getToastrs(): array
    {
        return $this->toastrs ?? [];
    }

    /**
    * トーストの初期化
    * @return void
    */
    public function initToastr(): void
    {
        $this->toastrs = [];
    }

}
