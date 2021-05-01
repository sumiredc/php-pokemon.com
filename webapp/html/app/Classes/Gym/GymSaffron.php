<?php
require_once app_path('Classes/Gym.php');
/**
* ヤマブキジム
*/
abstract class GymSaffron extends Gym
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'ヤマブキジム';

    /**
    * ジムリーダー
    * @var string
    */
    public const LEADER = 'natsume';

    /**
    * ジムバッジ
    * @var string
    */
    public const BADGE = 'marsh';

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
