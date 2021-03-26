<?php

/**
* フィールド
*/
abstract class Field
{

    // メッセージの初期値
    public const SET_MSG = '';
    public const ALREADY_MSG = '';
    public const RELEASE_MSG = '';
    public const FAILED_MSG = '';

    /**
    * フィールドセット時のメッセージ
    * @param target:string
    * @return string
    */
    public static function getSetMessage(string $target): string
    {
        $prefix = ($target === 'enemy') ? '相手' : '味方';
        return str_replace('::prefix', $prefix, static::SET_MSG);
    }

    /**
    * 既にフィールドがセットされている時のメッセージ
    * @param target:string
    * @return string
    */
    public static function getAlreadyMessage(string $target): string
    {
        $prefix = ($target === 'enemy') ? '相手' : '味方';
        return str_replace('::prefix', $prefix, static::ALREADY_MSG);
    }

    /**
    * フィールド解除時のメッセージ
    * @param target:string
    * @return string
    */
    public static function getReleaseMessage(string $target): string
    {
        $prefix = ($target === 'enemy') ? '相手' : '味方';
        return str_replace('::prefix', $prefix, static::RELEASE_MSG);
    }

    /**
    * 状態異常にかかった際のメッセージを取得
    * @param pokemon:string
    * @return string
    */
    public static function getFailedMessage(string $pokemon): string
    {
        return str_replace('::pokemon', $pokemon, static::FAILED_MSG);
    }

}
