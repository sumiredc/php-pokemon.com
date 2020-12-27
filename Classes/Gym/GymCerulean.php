<?php
require_once(root_path('Classes').'Gym.php');
/**
* ハナダジム
*/
abstract class GymCerulean extends Gym
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'ハナダジム';

    /**
    * ジムリーダー
    * @var string
    */
    public const LEADER = 'Kasumi';

    /**
    * ジムバッジ
    * @var string
    */
    public const BADGE = 'Cascade';

    /**
    * 挑戦条件
    * @var array
    */
    public const REQUIRED_CHALLENGE = [];

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
