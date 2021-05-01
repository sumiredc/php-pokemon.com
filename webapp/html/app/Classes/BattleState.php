<?php
// トレイト
require_once app_path('Traits/Class/BattleState/ClassBattleStateFieldTrait.php');
require_once app_path('Traits/Class/BattleState/ClassBattleStateMoveTrait.php');
require_once app_path('Traits/Class/BattleState/ClassBattleStateMoneyTrait.php');
require_once app_path('Traits/Class/BattleState/ClassBattleStatePokemonTrait.php');
// require_once app_path('Traits/Class/BattleState/ClassBattleStateTransformTrait.php');
require_once app_path('Traits/Class/BattleState/ClassBattleStateTurnDamageTrait.php');
require_once app_path('Traits/Class/BattleState/ClassBattleStateTrainerTrait.php');

/**
* バトル状態クラス
*/
class BattleState
{

	/** @var boolean */
	protected $gym_flg = false;

    use ClassBattleStateFieldTrait, ClassBattleStateMoveTrait, ClassBattleStateMoneyTrait, ClassBattleStatePokemonTrait, ClassBattleStateTurnDamageTrait, ClassBattleStateTrainerTrait;

    /**
    * @param string $mode
    * @return void
    */
    public function __construct(string $mode)
    {
        $this->init();
		if(in_array($mode, ['trainer', 'leader'], true)){
			$this->mode('trainer');
		}else{
			$this->mode('wild');
		}
		// フラグ
		$this->gym_flg = ($mode === 'leader');
    }

    /**==================================================================
    * 初期化・初期値
    ==================================================================**/

    /**
    * 初期化
    * @return void
    */
    public function init(): void
    {
        $this->run = 0;
        $this->initFields();
        $this->initTurnDamages()->initTempParams();
        // $this->initTransforms();
        $this->initSelectedMoves();
        $this->initLastMoves();
    }

    /**
    * ターン始めの状態へ初期化
    * @return void
    */
    public function turnInit(): void
    {
		$this->initTurnDamages()
		->judgeTrue();
    }

    /**
    * 交換時の初期化
    * @param position:string::friend|enemy
    * @return void
    */
    public function changeInit(string $position): void
    {
        // ターンダメージ、最後に使った技をリセット
        if(in_array($position, config('pokemon.position'), true)){
            $this->resetTurnDamege($position);
            $this->resetLastMove($position);
        }
    }

	/**==================================================================
    * 一時保存用
    ==================================================================**/

	/**
	* 一時保存用
	* @var array
	*/
	private $temp_params = [];

	/**
	* 一時保存用のパラメーターの初期化
	* @return App\Classes\BattleState
	*/
	private function initTempParams(): BattleState
	{
		$this->temp_params = [];
		return $this;
	}

	/**
    * 一時保存用のパラメーターを保存
	* @access public
    * @param string $key
	* @param mixed $value
    * @return App\Classes\BattleState
    */
    public function setTempParam(string $key, $value): BattleState
    {
        $this->temp_params[$key] = $value;
		return $this;
    }

	/**
    * 一時保存用のパラメーターを保存
	* @access public
    * @param string $key
    * @return mixed
    */
    public function getTempParam(string $key)
    {
        return $this->temp_params[$key] ?? null;
    }

	/**
    * 一時保存用のパラメーターを削除
	* @access public
    * @param string $key
    * @return App\Classes\BattleState
    */
    public function unsetTempParam(string $key): BattleState
    {
		unset($this->temp_params[$key]);
        return $this;
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
        if(in_array($mode, ['wild', 'trainer', 'leader'], true)){
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

	/**
    * ジム戦かどうかの判定
    * @return boolean
    */
    public function isGym(): bool
    {
        return $this->gym_flg;
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
    * @return App\Classes\BattleState
    */
    public function judgeTrue(): BattleState
    {
        $this->judgement = true;
		return $this;
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
