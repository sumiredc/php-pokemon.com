<?php
$root_path = __DIR__.'/..';
// トレイト
require_once($root_path.'/App/Traits/Class/BattleState/ClassBattleStateFieldTrait.php');
require_once($root_path.'/App/Traits/Class/BattleState/ClassBattleStateLastMoveTrait.php');
require_once($root_path.'/App/Traits/Class/BattleState/ClassBattleStateMoneyTrait.php');
require_once($root_path.'/App/Traits/Class/BattleState/ClassBattleStatePokemonTrait.php');
require_once($root_path.'/App/Traits/Class/BattleState/ClassBattleStateTransformTrait.php');
require_once($root_path.'/App/Traits/Class/BattleState/ClassBattleStateTurnDamageTrait.php');

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
    * ひんし状態の格納
    * @var array
    */
    protected $fainting;

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

    /**
    * へんしん情報
    * @var array
    */
    private $transforms;

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
        $this->dafaultFainting();
        $this->dafaultFields();
        $this->dafaultTurnDamages();
        $this->dafaultTransforms();
        $this->dafaultLastMoves();
    }

    /**
    * ターン始めの状態へ初期化
    * @return void
    */
    public function turnInit() :void
    {
        $this->dafaultTurnDamages();
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

}
