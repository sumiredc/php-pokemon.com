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
        // [1, 'MoveHighJumpKick'],        # とびひざげり
        // [1, 'MoveHyperBeam'],           # はかいこうせん
        [1, 'MovePsychic'],           # サイコキネシス
        // [1, 'MoveLeechSeed'],           # やどりぎのたね
        // [1, 'MoveConfuseRay'],          # あやしいひかり
        // [1, 'MoveSeismicToss'],         # ちきゅうなげ
        // [1, 'MovePsywave'],             # サイコウェーブ
        // [1, 'MoveCounter'],             # カウンター
        // [1, 'MoveRage'],                # いかり
        // [1, 'MoveSandAttack'],          # すなかけ
        // [1, 'MoveWhirlwind'],           # ふきとばし
        // [1, 'MoveDoubleTeam'],          # かげぶんしん
        // [1, 'MoveFly'],                 # そらをとぶ
        // [1, 'MoveDig'],                 # あなをほる
        // [1, 'MoveMist'],           # しろいきり
        // [1, 'MoveReflect'],           # リフレクター
        // [1, 'MoveLightScreen'],           # ひかりのかべ
        [1, 'MovePoisonPowder'],   # どくのこな
        [1, 'MoveSleepPowder'],    # ねむりごな
        // [1, 'MoveThunderWave'],     # でんじは
        [1, 'MoveThrash'],     # あばれる
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
