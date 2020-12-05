<?php
require_once(__DIR__.'/../Pokemon.php');

// ミュウ
class Mew extends Pokemon
{

    /**
    * ポケモン全国図鑑ナンバー
    * @var integer
    */
     public const NUMBER = 151;

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
     public const NAME = 'ミュウ';

     /**
     * 分類
     * @var string
     */
     public const SPECIES = 'しんしゅポケモン';

     /**
     * 説明文
     * @var string
     */
     public const DESCRIPTION = 'すべての ポケモンの 先祖と 考えられている。 知能が 高く あらゆる 技が 使える。';

    /**
    * タイプ
    * @var array
    */
     public const TYPES = ['TypePsychic'];

    /**
    * 基礎経験値
    * @var integer
    */
     public const BASE_EXP = 300;

    /**
    * 捕捉率
    * @var integer
    */
     public const CAPTURE = 45;

    /**
    * 重さ
    * @var float
    */
     public const WEIGHT = 4.0;

    /**
    * レベルアップで覚える技
    * @var array
    */
     public const LEVEL_MOVE = [
        [1, 'MovePound'],                  # はたく
        [10, 'MoveTransform'],             # へんしん
        [20, 'MoveWingAttack'],            # メガトンパンチ
        [30, 'MoveMetronome'],             # ゆびをふる
        [40, 'MovePsychic'],               # サイコキネシス

        // [1, 'MoveMetronome'],             # ゆびをふる
        // [1, 'MoveTransform'],             # へんしん
        // [1, 'MoveMist'],           # しろいきり
        // [1, 'MoveHighJumpKick'],        # とびひざげり
        // [1, 'MoveReflect'],           # リフレクター
        // [1, 'MoveCometPunch'],            # れんぞくパンチ
        // [1, 'MoveCounter'],             # カウンター
        // [1, 'MoveRage'],         # いかり
        // [1, 'MoveLowKick'],         # けたぐり
        // [1, 'MoveHyperBeam'],           # はかいこうせん
        // [6, 'MoveEarthquake'],       # じしん
        // [1, 'MoveThrash'],     # あばれる
        // [1, 'MoveFissure'],        # じわれ
        // [1, 'MovePoisonPowder'],   # どくのこな
        // [1, 'MoveSleepPowder'],    # ねむりごな
        // [1, 'MoveThunderWave'],     # でんじは
        // [1, 'MoveLightScreen'],           # ひかりのかべ
        // [10, 'MoveSandAttack'],          # すなかけ
        // [1, 'MoveWhirlwind'],           # ふきとばし
        // [12, 'MoveDoubleTeam'],          # かげぶんしん
        // [13, 'MoveFly'],                 # そらをとぶ
        // [1, 'MoveDig'],                 # あなをほる
        // [1, 'MoveLeechSeed'],           # やどりぎのたね
        // [1, 'MoveConfuseRay'],          # あやしいひかり
        // [1, 'MoveSeismicToss'],         # ちきゅうなげ
        // [1, 'MovePsywave'],             # サイコウェーブ
        // [1, 'MoveRage'],                # いかり
        // [1, 'MoveMirrorMove'],             # オウムがえし
        // [1, 'MoveGrowth'],            # せいちょう
        // [1, 'MovePayDay'],            # ネコにこばん
        // [1, 'MoveFireSpin'],            # ほのおのうず
        // [1, 'MoveExplosion'],              # だいばくはつ

        // [1, 'MoveOutrage'],                 # げきりん（威力10）
    ];

    /**
    * 種族値
    * @var array
    */
    public const BASE_STATS = [
        'H' => 100,
        'A' => 100,
        'B' => 100,
        'C' => 100,
        'D' => 100,
        'S' => 100,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    public const REWARD_EV = [
        'H' => 3,
    ];

}
