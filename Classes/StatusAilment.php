<?php

// 状態異常
abstract class StatusAilment
{

    // プロパティの初期値
    protected $sicked_msg = '';
    protected $sicked_already_msg = '';
    protected $turn_msg = '';
    protected $false_msg = '';
    protected $recovery_msg = '';

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
    * 状態異常にかかった際のメッセージを取得
    *
    * @param string $pokemon
    * @return string
    */
    public function getSickedMessage($pokemon)
    {
        return str_replace('::pokemon', $pokemon, $this->sicked_msg);
    }

    /**
    * 既に状態異常にかかっている際のメッセージを取得
    *
    * @param string $pokemon
    * @return string
    */
    public function getSickedAlreadyMessage($pokemon)
    {
        return str_replace('::pokemon', $pokemon, $this->sicked_already_msg);
    }

    /**
    * ターンチェック時のメッセージを取得
    *
    * @param string $pokemon
    * @return string
    */
    public function getTurnMessage($pokemon)
    {
        return str_replace('::pokemon', $pokemon, $this->turn_msg);
    }

    /**
    * 行動失敗時のメッセージを取得
    *
    * @param string $pokemon
    * @return string
    */
    public function getFalseMessage($pokemon)
    {
        return str_replace('::pokemon', $pokemon, $this->false_msg);
    }

    /**
    * 回復時のメッセージを取得
    *
    * @param string $pokemon
    * @return string
    */
    public function getRecoveryMessage($pokemon)
    {
        return str_replace('::pokemon', $pokemon, $this->recovery_msg);
    }

}
