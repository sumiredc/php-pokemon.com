<?php
require_once(root_path('Classes').'Gym.php');
/**
* クチバジム
*/
abstract class GymVermilion extends Gym
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'クチバジム';

    /**
    * ジムリーダー
    * @var string
    */
    public const LEADER = 'Machisu';

    /**
    * ジムバッジ
    * @var string
    */
    public const BADGE = 'Thunder';

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
