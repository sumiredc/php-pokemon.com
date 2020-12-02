<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/StatusAilment.php');

/**
* もうどく
*/
class SaBadPoison extends StatusAilment
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'もうどく';

    /**
    * 色
    * @var string
    */
    public const COLOR = 'purple';

    /**
    * 状態異常にかかった際のメッセージ
    * @var string
    */
    public const SICKED_MSG = '::pokemonは、猛毒を浴びた';

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
