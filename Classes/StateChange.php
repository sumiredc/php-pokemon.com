<?php

// 状態変化
abstract class StateChange
{

    // メッセージの初期値
    public const SICKED_MSG = '';
    public const SICKED_ALREADY_MSG = '';
    public const TURN_MSG = '';
    public const FAILED_MSG = '';
    public const RECOVERY_MSG = '';
    public const ACTIVE_MSG = '';

    /**
    * 状態変化にかかった際のメッセージを取得
    * @param pokemon:string
    * @return string
    */
    public static function getSickedMessage(string $pokemon, string $param='Standard')
    {
        if(is_array(static::SICKED_MSG)){
            return str_replace('::pokemon', $pokemon, static::SICKED_MSG[$param]);
        }else{
            return str_replace('::pokemon', $pokemon, static::SICKED_MSG);
        }
    }

    /**
    * 既に状態変化にかかっている際のメッセージを取得
    * @param pokemon:string
    * @return string
    */
    public static function getSickedAlreadyMessage(string $pokemon, string $param='Standard')
    {
        if(is_array(static::SICKED_ALREADY_MSG)){
            return str_replace('::pokemon', $pokemon, static::SICKED_ALREADY_MSG[$param]);
        }else{
            return str_replace('::pokemon', $pokemon, static::SICKED_ALREADY_MSG);
        }
    }

    /**
    * ターンメッセージを取得
    * @param pokemon:string
    * @return string
    */
    public static function getTurnMessage(string $pokemon, string $param='Standard')
    {
        if(is_array(static::TURN_MSG)){
            return str_replace('::pokemon', $pokemon, static::TURN_MSG[$param]);
        }else{
            return str_replace('::pokemon', $pokemon, static::TURN_MSG);
        }

    }

    /**
    * 行動失敗時のメッセージを取得
    * @param pokemon:string
    * @return string
    */
    public static function getFailedMessage(string $pokemon, string $param='Standard')
    {
        if(is_array(static::FAILED_MSG)){
            return str_replace('::pokemon', $pokemon, static::FAILED_MSG[$param]);
        }else{
            return str_replace('::pokemon', $pokemon, static::FAILED_MSG);
        }
    }

    /**
    * 回復時のメッセージを取得
    * @param pokemon:string
    * @param param:string
    * @return string
    */
    public static function getRecoveryMessage(string $pokemon, string $param='Standard')
    {
        if(is_array(static::RECOVERY_MSG)){
            return str_replace('::pokemon', $pokemon, static::RECOVERY_MSG[$param]);
        }else{
            return str_replace('::pokemon', $pokemon, static::RECOVERY_MSG);
        }
    }

    /**
    * 発動時のメッセージを取得
    * @param pokemon:string
    * @return string
    */
    public static function getActiveMessage(string $pokemon)
    {
        return str_replace('::pokemon', $pokemon, static::ACTIVE_MSG);
    }

}
