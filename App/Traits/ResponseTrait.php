<?php
trait ResponseTrait
{
    /**
    * メッセージの格納用
    * @var array
    */
    private $msgs = [];

    /**
    * レスポンステータの格納用
    * @var array
    */
    private $responses = [];

    /**
    * メッセージの取得
    *
    * @return array
    */
    public function getMessages()
    {
        return $this->msgs;
    }

    /**
    * メッセージの格納
    *
    * @param string|array $msg
    * @param string $param error|success default=null
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
            $this->msgs = array_merge($this->msgs, $msg);
        }else{
            // 単発登録
            $this->msgs[] = [$msg, $param];
        }
    }

    /**
    * メッセージの初期化
    *
    * @return void
    */
    public function resetMessage()
    {
        $this->msgs = [];
    }

    /**
    * メッセージの最初のキーを取得
    *
    * @return void
    */
    public function getMessageFirstKey()
    {
        return array_key_first($this->msgs);
    }

    /**
    * メッセージの最後のキーを取得
    *
    * @return void
    */
    public function getMessageLastKey()
    {
        return array_key_last($this->msgs);
    }

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
    * @param mixed @response
    * @return array
    */
    public function setResponse($response, $key=null)
    {
        if(empty($response)){
            // 空の場合はスキップ
            return;
        }
        if(is_null($key)){
            $this->responses[] = $response;
        }else{
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

}
