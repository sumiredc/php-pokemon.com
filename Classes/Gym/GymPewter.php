<?php
require_once(root_path('Classes').'Gym.php');
/**
* ニビジム
*/
abstract class GymPewter extends Gym
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'ニビジム';

    /**
    * ジムリーダー
    * @var string
    */
    public const LEADER = 'Takeshi';

    /**
    * ジムバッジ
    * @var string
    */
    public const BADGE = 'Boulder';

    /**
    * 挑戦条件
    * @var array
    */
    public const REQUIRED_CHALLENGE = [
        'プレイヤーレベル 8以上',
        'トレーナー戦の勝利数 3以上',
    ];

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
