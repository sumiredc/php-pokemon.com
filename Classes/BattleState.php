<?php
// トレイト
require_once(app_path('Traits.Class.BattleState').'ClassBattleStateFieldTrait.php');
require_once(app_path('Traits.Class.BattleState').'ClassBattleStateLastMoveTrait.php');
require_once(app_path('Traits.Class.BattleState').'ClassBattleStateMoneyTrait.php');
require_once(app_path('Traits.Class.BattleState').'ClassBattleStatePokemonTrait.php');
require_once(app_path('Traits.Class.BattleState').'ClassBattleStateTransformTrait.php');
require_once(app_path('Traits.Class.BattleState').'ClassBattleStateTurnDamageTrait.php');

/**
* バトル状態クラス
*/
class BattleState
{

    use ClassBattleStateFieldTrait;
    use ClassBattleStateLastMoveTrait;
    use ClassBattleStateMoneyTrait;
    use ClassBattleStatePokemonTrait;
    use ClassBattleStateTransformTrait;
    use ClassBattleStateTurnDamageTrait;

    /**
    * 味方
    * @var object::Pokemon
    */
    private $friend;

    /**
    * 相手
    * @var object::Pokemon
    */
    private $enemy;

    /**
    * 戦闘に参加しているポケモン番号
    * @var integer
    */
    protected $order;

    /**
    * 前ターンのポケモンの状態
    * @var array
    */
    protected $before;

    /**
    * 逃走を試みた回数
    * @var integer
    */
    private $run;

    /**
    * フィールド効果
    * @var integer
    */
    private $fields;

    /**
    * このターンに受けた攻撃によるダメージ量
    * @var array
    */
    private $turn_damages;

    // /**
    // * へんしん情報
    // * @var array
    // */
    // private $transforms;

    /**
    * 最後に使用した技
    * @var array
    */
    private $last_moves;

    /**
    * 散らばったお金
    * @var array
    */
    private $money = [];

    /**
    * 戦闘に参加したポケモン番号
    * @var array
    */
    private $fought_orders = [];

    /**
    * 判定有無確認用フラグ
    * @var boolean
    */
    private $judgement = true;

    /**
    * @return void
    */
    public function __construct()
    {
        $this->init();
    }

    /**==================================================================
    * 初期化・初期値
    ==================================================================**/

    /**
    * 初期化
    * @return void
    */
    public function init() :void
    {
        $this->run = 0;
        $this->initFields();
        $this->initTurnDamages();
        $this->initTransforms();
        $this->initLastMoves();
    }

    /**
    * ターン始めの状態へ初期化
    * @return void
    */
    public function turnInit() :void
    {
        $this->initTurnDamages();
        $this->judgeTrue();
    }

    /**
    * 交換時の初期化
    * @param position:string::friend|enemy
    * @return void
    */
    public function changeInit(string $position) :void
    {
        // ターンダメージ、へんしん、最後に使った技をリセット
        if(in_array($position, config('pokemon.position'), true)){
            $this->resetTurnDamege($position);
            // $this->resetTransform($position);
            $this->resetLastMove($position);
        }
    }

    /**==================================================================
    * にげる
    ==================================================================**/

    /**
    * にげる実行
    * @return void
    */
    public function run() :void
    {
        $this->run++;
    }

    /**
    * にげるの回数取得
    * @return integer
    */
    public function getRun() :int
    {
        return $this->run;
    }

    /**==================================================================
    * 判定確認用フラグ
    ==================================================================**/

    /**
    * 判定不要にする処理
    * @return void
    */
    public function judgeFalse(): void
    {
        $this->judgement = false;
    }

    /**
    * 要判定にする処理
    * @return void
    */
    public function judgeTrue(): void
    {
        $this->judgement = true;
    }

    /**
    * 判定有無の確認
    * @return boolean
    */
    public function isJudge(): bool
    {
        return $this->judgement;
    }

}
