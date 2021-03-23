<?php
require_once(root_path('Classes').'Gym.php');
/**
* トキワジム
*/
abstract class GymViridian extends Gym
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'トキワジム';

    /**
    * ジムリーダー
    * @var string
    */
    public const LEADER = 'Sakaki';

    /**
    * ジムバッジ
    * @var string
    */
    public const BADGE = 'Earth';

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
