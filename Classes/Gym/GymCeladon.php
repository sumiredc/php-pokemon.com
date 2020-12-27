<?php
require_once(root_path('Classes').'Gym.php');
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
    public const LEADER = 'Erika';

    /**
    * ジムバッジ
    * @var string
    */
    public const BADGE = 'Rainbow';

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
