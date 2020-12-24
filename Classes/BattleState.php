<?php
// トレイト
require_once(app_path('Traits.Class.BattleState').'ClassBattleStateFieldTrait.php');
require_once(app_path('Traits.Class.BattleState').'ClassBattleStateMoveTrait.php');
require_once(app_path('Traits.Class.BattleState').'ClassBattleStateMoneyTrait.php');
require_once(app_path('Traits.Class.BattleState').'ClassBattleStatePokemonTrait.php');
// require_once(app_path('Traits.Class.BattleState').'ClassBattleStateTransformTrait.php');
require_once(app_path('Traits.Class.BattleState').'ClassBattleStateTurnDamageTrait.php');
require_once(app_path('Traits.Class.BattleState').'ClassBattleStateTrainerTrait.php');

/**
* バトル状態クラス
*/
class BattleState
{

    use ClassBattleStateFieldTrait;
    use ClassBattleStateMoveTrait;
    use ClassBattleStateMoneyTrait;
    use ClassBattleStatePokemonTrait;
    // use ClassBattleStateTransformTrait;
    use ClassBattleStateTurnDamageTrait;
    use ClassBattleStateTrainerTrait;

    /**
    * @param mode:string
    * @return void
    */
    public function __construct(string $mode)
    {
        $this->init();
        $this->mode($mode);
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
        // $this->initTransforms();
        $this->initSelectedMoves();
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
        // ターンダメージ、最後に使った技をリセット
        if(in_array($position, config('pokemon.position'), true)){
            $this->resetTurnDamege($position);
            $this->resetLastMove($position);
        }
    }

    /**==================================================================
    * バトルモード
    ==================================================================**/

    /**
    * バトルモード（初期値：野生）
    * @var string::wild|trainer
    */
    private $mode = 'wild';

    /**
    * モードの切替え
    * @param mode:string
    * @return void
    */
    private function mode(string $mode): void
    {
        if(in_array($mode, ['wild', 'trainer'], true)){
            $this->mode = $mode;
        }
    }

    /**
    * 現在のモードを確認
    * @param mode:string
    * @return boolean
    */
    public function isMode(string $mode): bool
    {
        return $this->mode === $mode;
    }

    /**==================================================================
    * にげる
    ==================================================================**/

    /**
    * 逃走を試みた回数
    * @var integer
    */
    private $run;

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
    * 判定有無確認用フラグ
    * @var boolean
    */
    private $judgement = true;

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
