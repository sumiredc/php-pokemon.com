<?php
require_once(__DIR__.'/../Pokemon.php');

// ミュウ
class Mew extends Pokemon
{

    /**
    * ポケモンナンバー
    * @var integer
    */
     protected $number = 151;

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
     protected $name = 'ミュウ';

    /**
    * タイプ
    * @var array
    */
     protected $types = ['TypePsychic'];

    /**
    * 基礎経験値
    * @var integer
    */
     protected $base_exp = 300;

    /**
    * 捕捉率
    * @var integer
    */
     protected $capture = 45;

    /**
    * 重さ
    * @var float
    */
     protected $weight = 4.0;

    /**
    * レベルアップで覚える技
    * @var array
    */
     protected $level_move = [
        [1, 'MovePound'],                  # はたく
        [10, 'MoveTransform'],             # へんしん
        [20, 'MoveWingAttack'],            # メガトンパンチ
        [30, 'MoveMetronome'],             # ゆびをふる
        [40, 'MovePsychic'],               # サイコキネシス

        [1, 'MoveExplosion'],              # だいばくはつ
        // [6, 'MoveMist'],           # しろいきり
        // [1, 'MoveHighJumpKick'],        # とびひざげり
        // [1, 'MoveReflect'],           # リフレクター
        // [1, 'MoveHyperBeam'],           # はかいこうせん
        // [6, 'MoveEarthquake'],       # じしん
        // [6, 'MoveThrash'],     # あばれる
        // [1, 'MoveFissure'],        # じわれ
        // [1, 'MovePoisonPowder'],   # どくのこな
        // [1, 'MoveSleepPowder'],    # ねむりごな
        // [1, 'MoveThunderWave'],     # でんじは
        // [1, 'MoveLightScreen'],           # ひかりのかべ
        // [10, 'MoveSandAttack'],          # すなかけ
        // [11, 'MoveWhirlwind'],           # ふきとばし
        // [12, 'MoveDoubleTeam'],          # かげぶんしん
        // [13, 'MoveFly'],                 # そらをとぶ
        // [14, 'MoveDig'],                 # あなをほる
        // [1, 'MoveLeechSeed'],           # やどりぎのたね
        // [1, 'MoveConfuseRay'],          # あやしいひかり
        // [1, 'MoveSeismicToss'],         # ちきゅうなげ
        // [1, 'MovePsywave'],             # サイコウェーブ
        // [1, 'MoveCounter'],             # カウンター
        // [1, 'MoveRage'],                # いかり
        // [1, 'MoveMirrorMove'],             # オウムがえし
        // [1, 'MoveCometPunch'],            # れんぞくパンチ
        // [1, 'MoveGrowth'],            # せいちょう
        // [1, 'MovePayDay'],            # ネコにこばん
        // [1, 'MoveFireSpin'],            # ほのおのうず
        // [1, 'MoveRage'],         # いかり
        // [1, 'MoveLowKick'],         # けたぐり
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
