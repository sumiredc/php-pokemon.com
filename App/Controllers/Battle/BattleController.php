<?php
$root_path = __DIR__.'/../../..';
require_once($root_path.'/App/Controllers/Controller.php');
// サービス
require_once($root_path.'/App/Services/Battle/StartService.php');
require_once($root_path.'/App/Services/Battle/RunService.php');
require_once($root_path.'/App/Services/Battle/FightService.php');
require_once($root_path.'/App/Services/Battle/LearnMoveService.php');
// トレイト
// require_once($root_path.'/App/Traits/Common/CommonFieldTrait.php');
require_once($root_path.'/App/Traits/Controller/BattleControllerTrait.php');
// クラス
require_once($root_path.'/Classes/BattleState.php');

// バトル用コントローラー
class BattleController extends Controller
{

    // use CommonFieldTrait;
    use BattleControllerTrait;

    /**
    * 戦闘に参加しているポケモン番号
    * @var integer
    */
    protected $order;

    /**
    * 味方ポケモン格納用
    * @var object
    */
    protected $pokemon;

    /**
    * 敵ポケモン格納用
    * @var object
    */
    protected $enemy;

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
        $this->inheritance();
        // 分岐処理
        $this->branch();
        // 次のターンへの分岐(ループ処理)
        while($this->nextTurn());
    }

    /**
    * @return void
    */
    public function __destruct()
    {
        // 次画面へ送るデータ
        $_SESSION['__data']['party'] = serializeObject($this->party);
        $_SESSION['__data']['enemy'] = serializeObject($this->enemy);
        $_SESSION['__data']['battle_state'] = serializeObject($this->battle_state);
        $_SESSION['__data']['before_responses'] = serializeObject(getResponses());
        $_SESSION['__data']['before_modals'] = serializeObject(getModals());
        $_SESSION['__data']['before_messages'] = getMessages();
        // 親デストラクタの呼び出し
        parent::__destruct();
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
                    $this->battle_state
                );
                $service->execute();
                // 実行結果
                $this->fainting = $service->getProperty('fainting');
                break;
                /******************************************
                * にげる
                */
                case 'run':
                // 回数をプラス
                // $this->run++;
                // サービス実行
                $service = new RunService(
                    $this->pokemon,
                    $this->enemy,
                    $this->battle_state
                    // $this->run,
                    // $this->field
                );
                $service->execute();
                // 実行結果
                if(!getResponse('result')){
                    // 失敗
                    $this->fainting = $service->getProperty('fainting');
                    // $this->field = $service->getProperty('field');
                }
                break;
                /******************************************
                * 技の習得
                */
                case 'learn_move':
                // サービス実行
                $service = new LearnMoveService(
                    $this->pokemon,
                    $_SESSION['__data']['before_responses'],
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
                if(
                    empty($this->enemy->getRemainingHp()) ||
                    empty($this->pokemon->getRemainingHp())
                ){
                    $this->battleEnd();
                }
                break;
            }
        } catch (\Exception $ex) {
            // 初期画面へ移管
            $_SESSION['__route'] = 'initial';
            // 画面移管
            $this->redirect();
        }
    }

    /**
    * バトル終了メソッド
    *
    * @return boolean
    */
    private function battleEnd()
    {
        // パーティーのランク補正・状態変化を解除
        array_map(function($partner){
            $partner->releaseBattleStatsAll();
        }, $this->party);        
        // セッション破棄
        $keys = [
            'pokemon', 'enemy', 'order', 'battle_state',
            'before_responses', 'before_messages', 'before_modals'
        ];
        foreach($keys as $key){
            unset($_SESSION['__data'][$key]);
        }
        // 進化フラグのチェック
        $evolves = array_filter($this->party, function($pokemon){
            return $pokemon->getEvolveFlg();
        });
        if($evolves){
            // 進化画面へ移管
            $_SESSION['__route'] = 'evolve';
        }else{
            // ホーム画面へ移管
            $_SESSION['__route'] = 'home';
        }
        // 画面移管
        $this->redirect();
    }

}
