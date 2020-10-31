<?php
$root_path = __DIR__.'/../../..';
require_once($root_path.'/App/Controllers/Controller.php');
// サービス
require_once($root_path.'/App/Services/Battle/StartService.php');
require_once($root_path.'/App/Services/Battle/RunService.php');
require_once($root_path.'/App/Services/Battle/FightService.php');
require_once($root_path.'/App/Services/Battle/LearnMoveService.php');
// トレイト
require_once($root_path.'/App/Traits/Common/CommonFieldTrait.php');
require_once($root_path.'/App/Traits/Controller/BattleControllerTrait.php');

// バトル用コントローラー
class BattleController extends Controller
{

    use CommonFieldTrait;
    use BattleControllerTrait;

    /**
    * 敵ポケモン格納用
    * @var object
    */
    protected $enemy;

    /**
    * 逃走を試みた回数
    * @var integer
    */
    public $run = 0;

    /**
    * フィールド効果
    * @var integer
    */
    protected $field = [
        'friend' => [],
        'enemy' => [],
    ];

    /**
    * ひんし状態の格納
    * @var array
    */
    protected $fainting = [
        'friend' => false,
        'enemy' => false,
    ];

    /**
    * 前ターンのポケモンの状態
    * @var array
    */
    protected $before = [
        'friend' => null,
        'enemy' => null,
    ];

    /**
    * @return void
    */
    public function __construct()
    {
        // 親コンストラクタの呼び出し
        parent::__construct();
        // 引き継ぎ
        $this->takeOver();
        // 分岐処理
        $this->branch();
        // 次のターンへの分岐(ループ処理)
        while($this->nextTurn());
        // 親デストラクタの呼び出し
        parent::__destruct();
    }

    /**
    * 引き継ぎ処理
    * @return void
    */
    private function takeOver()
    {
        // にげるの実行回数を引き継ぎ
        if(isset($_SESSION['__data']['run'])){
            $this->run = $_SESSION['__data']['run'];
        }
        // フィールド状態を引き継ぎ
        if(isset($_SESSION['__data']['field'])){
            $this->field = $_SESSION['__data']['field'];
        }
        // ========
        // パーティーの引き継ぎ
        $this->party = $this->unserializeObject($_SESSION['__data']['party']);
        // ========
        // ポケモンの引き継ぎ
        $this->pokemon = $this->unserializeObject($_SESSION['__data']['pokemon']);
        // 前ターンの状態をプロパティに格納
        $this->before['friend'] = clone $this->pokemon;
        // ========
        // 敵ポケモンの引き継ぎ
        if(isset($_SESSION['__data']['enemy'])){
            $this->enemy = $this->unserializeObject($_SESSION['__data']['enemy']);
            // 前ターンの状態をプロパティに格納
            $this->before['enemy'] = clone $this->enemy;
        }

    }

    /**
    * アクションに合わせた分岐
    * @return void
    */
    private function branch()
    {
        try {
            // アクション分岐
            switch ($this->request('action')) {
                /******************************************
                * 開始
                */
                case 'battle':
                // サービス実行
                $service = new StartService($this->pokemon);
                $service->execute();
                // 実行結果
                $this->enemy = $service->getProperty('enemy');
                // 前ターンの状態をプロパティに格納
                $this->before['enemy'] = clone $this->enemy;
                break;
                /******************************************
                * たたかう
                */
                case 'fight':
                // サービス実行
                $service = new FightService(
                    $this->pokemon,
                    $this->enemy,
                    $this->request('param'),
                    $this->field
                );
                $service->execute();
                // 実行結果
                $this->fainting = $service->getProperty('fainting');
                $this->field = $service->getProperty('field');
                break;
                /******************************************
                * にげる
                */
                case 'run':
                // 回数をプラス
                $this->run++;
                // サービス実行
                $service = new RunService(
                    $this->pokemon,
                    $this->enemy,
                    $this->run,
                    $this->field
                );
                $service->execute();
                // 実行結果
                if(!getResponse('result')){
                    // 失敗
                    $this->fainting = $service->getProperty('fainting');
                    $this->field = $service->getProperty('field');
                }
                break;
                /******************************************
                * 技の習得
                */
                case 'learn_move':
                // サービス実行
                $service = new LearnMoveService(
                    $this->pokemon,
                    $_SESSION['__data']['before_reponses'],
                    $_SESSION['__data']['before_messages'],
                    $_SESSION['__data']['before_modals'],
                    $this->request('param')
                );
                $service->execute();
                // 描画するポケモン情報を置き換え
                $this->before['friend'] = $service->getTmpPokemon();
                break;
                /******************************************
                * バトル終了
                */
                case 'end':
                $this->battleEnd();
                break;
                /******************************************
                * アクション未選択 or 実装されていないアクション
                */
                default:
                // もしどちらかが戦闘不能状態であればバトルを強制終了
                if(empty($this->enemy->getRemainingHp()) || empty($this->pokemon->getRemainingHp())){
                    $this->battleEnd();
                }
                break;
            }
        } catch (\Exception $e) {
            // 初期画面へ移管
            $_SESSION['__route'] = 'initial';
            header("Location: ./", true, 307);
            exit;
        }
    }

    /**
    * バトル終了メソッド
    *
    * @return boolean
    */
    private function battleEnd()
    {
        // ポケモンのランク補正・状態変化・バトルダメージを解除
        $this->pokemon
        ->releaseBattleStatsAll();
        // 更新したポケモンオブジェクトをセッションへ格納
        $_SESSION['__data']['pokemon'] = $this->serializeObject($this->pokemon);
        // セッション破棄
        $target = [
            'enemy', 'run', 'field',
            'before_responses', 'before_messages', 'before_modals'
        ];
        foreach($target as $key){
            unset($_SESSION['__data'][$key]);
        }
        // 進化フラグのチェック
        if($this->pokemon->getEvolveFlg()){
            // 進化画面へ移管
            $_SESSION['__route'] = 'evolve';
        }else{
            // ホーム画面へ移管
            $_SESSION['__route'] = 'home';
        }
        header("Location: ./", true, 307);
        exit;
    }

    /**
    * 次のターンへの判定処理
    *
    * @return boolean
    */
    private function nextTurn()
    {
        // ひんしポケモンがでた場合の処理
        if($this->fainting['enemy'] || $this->fainting['friend']){
            $this->judgment();
            return false;
        }
        // チャージ中、反動有り、あばれる状態なら再度アクション実行
        if(
            $this->chargeNow() ||
            $this->pokemon->checkSc('ScRecoil') ||
            $this->pokemon->checkSc('ScThrash')
        ){
            $this->branch();
            return true;
        }else{
            setMessage('行動を選択してください');
            return false;
        }
    }

}
