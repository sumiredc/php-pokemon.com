<?php
require_once app_path('Classes/Gym.php');
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
    public const LEADER = 'takeshi';

    /**
    * ジムバッジ
    * @var string
    */
    public const BADGE = 'boulder';

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
    * @param App\Classes\Player $player
    * @return boolean
    */
    public static function isRequiredChallenge(Player $player): bool
    {
		return true;
		
        return $player->getLevel() >= 8 &&
        $player->getCounter()['trainer']['win'] ?? 0 >= 3;
    }

}
