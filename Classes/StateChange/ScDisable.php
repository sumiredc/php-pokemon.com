<?php

require_once(root_path('Classes').'StateChange.php');

/**
* かなしばり
*/
class ScDisable extends StateChange
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'かなしばり';

    /**
    * 状態変化にかかった際のメッセージ
    * @var string
    */
    public const SICKED_MSG = '::pokemonは、かなしばりで、::moveが使えなくなった';

    /**
    * すでにこの状態変化にかかっている際のメッセージ
    * @var string
    */
    public const SICKED_ALREADY_MSG = 'しかし、上手く決まらなかった';

    /**
    * 行動失敗
    * @var string
    */
    public const FAILED_MSG = '::pokemonは、かなしばりで、::moveが出せない！';

    /**
    * 回復時に表示されるメッセージ
    * @var string
    */
    public const RECOVERY_MSG = '::pokemonは、かなしばりから開放された';

    /**
    * 状態変化にかかった際のメッセージを取得
    * @param pokemon:string
    * @param move:string
    * @return string
    */
    public static function getSickedMessage(string $pokemon, $move='')
    {
        return str_replace(
            ['::pokemon', '::move'],
            [$pokemon, $move::NAME],
            static::SICKED_MSG
        );
    }

    /**
    * 行動失敗時のメッセージを取得
    * @param pokemon:string
    * @param move:mixed
    * @return string
    */
    public static function getFailedMessage(string $pokemon, $move='')
    {
        return str_replace(
            ['::pokemon', '::move'],
            [$pokemon, $move::NAME],
            static::FAILED_MSG
        );
    }

}
