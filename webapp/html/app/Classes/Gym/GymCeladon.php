<?php
require_once app_path('Classes/Gym.php');
/**
* タマムシジム
*/
abstract class GymCeladon extends Gym
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'タマムシジム';

    /**
    * ジムリーダー
    * @var string
    */
    public const LEADER = 'erika';

    /**
    * ジムバッジ
    * @var string
    */
    public const BADGE = 'rainbow';

    /**
    * 挑戦条件
    * @var array
    */
    public const REQUIRED_CHALLENGE = ['準備中'];

    /**
    * 挑戦条件が満たされているかの確認
    * @param player:object::Player
    * @return boolean
    */
    public static function isRequiredChallenge(Player $player): bool
    {
        return false;
    }

}
