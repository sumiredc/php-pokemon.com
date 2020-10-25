<?php
require_once(__DIR__.'/../Pokemon.php');

// ミュウ
class Mew extends Pokemon
{

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    protected $name = 'ミュウ';

    /**
    * ニックネーム
    * @var string(min:1 max:5)
    */
    protected $nickname = 'デバッガー';

    /**
    * タイプ
    * @var array
    */
    protected $types = ['TypePsychic'];

    /**
    * 初期レベル
    * @var array
    */
    protected $default_level = [
        5
    ];

    /**
    * 基礎経験値
    * @var integer
    */
    protected $base_exp = 300;

    /**
    * レベルアップで覚える技
    * @var array
    */
    protected $level_move = [
        // [1, 'MoveFissure'],        # じわれ
        [1, 'MoveHighJumpKick'],        # とびひざげり
        [1, 'MoveHyperBeam'],           # はかいこうせん
        [1, 'MovePsychic'],           # サイコキネシス
        [1, 'MoveEarthquake'],       # じしん
        [6, 'MoveThrash'],     # あばれる
        [6, 'MoveMist'],           # しろいきり
        [6, 'MoveReflect'],           # リフレクター
        [7, 'MovePoisonPowder'],   # どくのこな
        [7, 'MoveSleepPowder'],    # ねむりごな
        [7, 'MoveThunderWave'],     # でんじは
        [9, 'MoveLightScreen'],           # ひかりのかべ
        [10, 'MoveSandAttack'],          # すなかけ
        [11, 'MoveWhirlwind'],           # ふきとばし
        [12, 'MoveDoubleTeam'],          # かげぶんしん
        [13, 'MoveFly'],                 # そらをとぶ
        [14, 'MoveDig'],                 # あなをほる
        // [1, 'MoveLeechSeed'],           # やどりぎのたね
        // [1, 'MoveConfuseRay'],          # あやしいひかり
        // [1, 'MoveSeismicToss'],         # ちきゅうなげ
        // [1, 'MovePsywave'],             # サイコウェーブ
        // [1, 'MoveCounter'],             # カウンター
        // [1, 'MoveRage'],                # いかり
    ];

    /**
    * 種族値
    * @var array
    */
    protected $base_stats = [
        'HP' => 100,
        'Attack' => 100,
        'Defense' => 100,
        'SpAtk' => 100,
        'SpDef' => 100,
        'Speed' => 100,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    protected $reward_ev = [
        'HP' => 3,
    ];

}
