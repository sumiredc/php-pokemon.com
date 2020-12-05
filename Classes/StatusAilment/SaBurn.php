<?php

require_once(root_path('Classes').'StatusAilment.php');

/**
* やけど
*/
class SaBurn extends StatusAilment
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'やけど';

    /**
    * 色
    * @var string
    */
    public const COLOR = 'danger';

    /**
    * 状態異常にかかった際のメッセージ
    * @var string
    */
    public const SICKED_MSG = '::pokemonは、やけどを負った';

    /**
    * すでにこの状態異常にかかっている際のメッセージ
    * @var string
    */
    public const SICKED_ALREADY_MSG = '::pokemonは、既にやけどしている';

    /**
    * ターンチェック時に表示されるメッセージ
    * @var string
    */
    public const TURN_MSG = '::pokemonは、やけどのダメージを受けている';

    /**
    * 回復時に表示されるメッセージ
    * @var string
    */
    public const RECOVERY_MSG = '::pokemonは、やけどが治った';

}
