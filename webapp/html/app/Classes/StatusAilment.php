<?php
/**
* 状態異常
*/
abstract class StatusAilment
{

    /**
    * 捕獲時の補正値(初期値)
    * @var float
    */
    public const CAPTURE = 1.5;

    // メッセージの初期値
    public const SICKED_MSG = '';
    public const SICKED_ALREADY_MSG = '';
    public const TURN_MSG = '';
    public const FAILED_MSG = '';
    public const RECOVERY_MSG = '';

    /**
    * 行動前の状態異常発症
    * @param pokemon:object
    * @return array
    */
    public static function onsetBefore(object $pokemon): array
    {
        return [
            'result' => true,
        ];
    }

    /**
    * 状態異常にかかった際のメッセージを取得
    * @param pokemon:string
    * @return string
    */
    public static function getSickedMessage(string $pokemon): string
    {
        return str_replace('::pokemon', $pokemon, static::SICKED_MSG);
    }

    /**
    * 既に状態異常にかかっている際のメッセージを取得
    * @param pokemon:string
    * @return string
    */
    public static function getSickedAlreadyMessage(string $pokemon): string
    {
        return str_replace('::pokemon', $pokemon, static::SICKED_ALREADY_MSG);
    }

    /**
    * ターンチェック時のメッセージを取得
    * @param pokemon:string
    * @return string
    */
    public static function getTurnMessage(string $pokemon): string
    {
        return str_replace('::pokemon', $pokemon, static::TURN_MSG);
    }

    /**
    * 行動失敗時のメッセージを取得
    * @param pokemon:string
    * @return string
    */
    public static function getFailedMessage(string $pokemon): string
    {
        return str_replace('::pokemon', $pokemon, static::FAILED_MSG);
    }

    /**
    * 回復時のメッセージを取得
    * @param pokemon:string
    * @return string
    */
    public static function getRecoveryMessage(string $pokemon): string
    {
        return str_replace('::pokemon', $pokemon, static::RECOVERY_MSG);
    }

}
