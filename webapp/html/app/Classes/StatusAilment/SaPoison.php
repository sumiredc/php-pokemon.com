<?php

require_once app_path('Classes/StatusAilment.php');

/**
* どく
*/
class SaPoison extends StatusAilment
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'どく';

    /**
    * 色
    * @var string
    */
    public const COLOR = 'purple';

    /**
    * 状態異常にかかった際のメッセージ
    * @var string
    */
    public const SICKED_MSG = '::pokemonは、毒を浴びた';

    /**
    * すでにこの状態異常にかかっている際のメッセージ
    * @var string
    */
    public const SICKED_ALREADY_MSG = '::pokemonは、既に毒に侵されている';

    /**
    * ターンチェック時に表示されるメッセージ
    * @var string
    */
    public const TURN_MSG = '::pokemonは、毒のダメージを受けている';

    /**
    * 回復時に表示されるメッセージ
    * @var string
    */
    public const RECOVERY_MSG = '::pokemonの毒は綺麗サッパリ無くなった';

}
