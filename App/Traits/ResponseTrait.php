<?php
trait ResponseTrait
{
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
    * メッセージIDの発行
    *
    * @return string
    */
    public function issueMsgId()
    {
        // IDを生成
        $id = 'msg'.substr(bin2hex(random_bytes(16)), 0, 16);
        // ユニークになるようにチェック
        while(in_array($id, $_SESSION['__message_ids'] ?? [], true)){
            $id = 'msg'.substr(bin2hex(random_bytes(16)), 0, 16);
        }
        $_SESSION['__message_ids'][] = $id;
        return $id;
    }

    /**
    * 全リセット
    *
    * @return void
    */
    public function resetResponsesAll()
    {
        $this->messages = [];
        $this->responses = [];
        $this->modals = [];
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
            // 一括登録
            $this->messages = array_merge($this->messages, $msg);
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
    public function setAutoMessage($param)
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
    *
    * @param array $param
    * @param boolean $merge
    * @return array
    */
    public function setModal(array $param, bool $merge=false)
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
            // モーダル起動時用のからメッセージをセット
            $this->messages[] = ['', '', ''];
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

}
