<?php

// 状態変化
abstract class StateChange
{

    // プロパティの初期値
    protected $sicked_msg = '';
    protected $sicked_already_msg = '';
    protected $turn_msg = '';
    protected $failed_msg = '';
    protected $recovery_msg = '';
    protected $active_msg = '';

    /**
    * インスタンス作成時に実行される処理
    *
    * @return void
    */
    public function __construct()
    {
        //
    }

    /**
    * 名称の取得
    *
    * @return string
    */
    public function getName()
    {
        return $this->name;
    }

    /**
    * 状態変化にかかった際のメッセージを取得
    *
    * @param string $pokemon
    * @return string
    */
    public function getSickedMessage($pokemon, $param='Standard')
    {
        if(is_array($this->sicked_msg)){
            return str_replace('::pokemon', $pokemon, $this->sicked_msg[$param]);
        }else{
            return str_replace('::pokemon', $pokemon, $this->sicked_msg);
        }

    }

    /**
    * 既に状態変化にかかっている際のメッセージを取得
    *
    * @param string $pokemon
    * @return string
    */
    public function getSickedAlreadyMessage($pokemon, $param='Standard')
    {
        if(is_array($this->sicked_already_msg)){
            return str_replace('::pokemon', $pokemon, $this->sicked_already_msg[$param]);
        }else{
            return str_replace('::pokemon', $pokemon, $this->sicked_already_msg);
        }

    }

    /**
    * ターンメッセージを取得
    *
    * @param string $pokemon
    * @return string
    */
    public function getTurnMessage($pokemon, $param='Standard')
    {
        if(is_array($this->turn_msg)){
            return str_replace('::pokemon', $pokemon, $this->turn_msg[$param]);
        }else{
            return str_replace('::pokemon', $pokemon, $this->turn_msg);
        }

    }

    /**
    * 行動失敗時のメッセージを取得
    *
    * @param string $pokemon
    * @return string
    */
    public function getFailedMessage($pokemon, $param='Standard')
    {
        if(is_array($this->failed_msg)){
            return str_replace('::pokemon', $pokemon, $this->failed_msg[$param]);
        }else{
            return str_replace('::pokemon', $pokemon, $this->failed_msg);
        }
    }

    /**
    * 回復時のメッセージを取得
    *
    * @param string $pokemon
    * @param string $param
    * @return string
    */
    public function getRecoveryMessage($pokemon, $param='Standard')
    {
        if(is_array($this->recovery_msg)){
            return str_replace('::pokemon', $pokemon, $this->recovery_msg[$param]);
        }else{
            return str_replace('::pokemon', $pokemon, $this->recovery_msg);
        }
    }

    /**
    * 発動時のメッセージを取得
    *
    * @param string $pokemon
    * @return string
    */
    public function getActiveMessage($pokemon)
    {
        return str_replace('::pokemon', $pokemon, $this->active_msg);
    }

}
