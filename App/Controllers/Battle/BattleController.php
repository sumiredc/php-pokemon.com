<?php
require_once(app_path('Controllers').'Controller.php');
// サービス
require_once(app_path('Services/Battle').'StartService.php');
require_once(app_path('Services/Battle').'StartTrainerService.php');
require_once(app_path('Services/Battle').'RunService.php');
require_once(app_path('Services/Battle').'FightService.php');
require_once(app_path('Services/Battle').'ItemService.php');
require_once(app_path('Services/Battle').'ChangeService.php');
require_once(app_path('Services/Battle').'LearnMoveService.php');
// トレイト
require_once(app_path('Traits/Controller').'BattleControllerTrait.php');

// バトル用コントローラー
class BattleController extends Controller
{

    use BattleControllerTrait;

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
        $_SESSION['__data']['battle_state'] = serializeObject(battle_state());
        $_SESSION['__data']['before_responses'] = serializeObject(response()->responses());
        $_SESSION['__data']['before_modals'] = serializeObject(response()->modals());
        $_SESSION['__data']['before_messages'] = response()->messages();
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
            switch (request('action')) {
                /******************************************
                * 野生ポケモン戦 開始
                */
                case 'battle':
                // サービス実行
                $service = new StartService;
                $service->execute();
                response()->setResponse(true, 'battle-start');
                break;
                /******************************************
                * トレーナー戦 開始
                */
                case 'battle_trainer':
                // サービス実行
                $service = new StartTrainerService;
                $service->execute();
                response()->setResponse(true, 'battle-start');
                break;
                /******************************************
                * たたかう
                */
                case 'fight':
                // サービス実行
                $service = new FightService;
                $service->execute();
                break;
                /******************************************
                * どうぐ
                */
                case 'item':
                // サービス実行
                $service = new ItemService;
                $service->execute();
                break;
                /******************************************
                * 交代
                */
                case 'change':
                // サービス実行
                $service = new ChangeService;
                $service->execute();
                break;
                /******************************************
                * にげる
                */
                case 'run':
                // サービス実行
                $service = new RunService;
                $service->execute();
                break;
                /******************************************
                * 技の習得
                */
                case 'learn_move':
                // サービス実行
                $service = new LearnMoveService(
                    $_SESSION['__data']['before_responses'],
                    $_SESSION['__data']['before_messages'],
                    $_SESSION['__data']['before_modals']
                );
                $service->execute();
                break;
                /******************************************
                * バトル終了
                */
                case 'end':
                $this->battleEnd();
                break;
                /******************************************
                * 降参（トレーナー戦のみ）
                */
                case 'surrender':
                if(battle_state()->isMode('trainer')){
                    // 持ち金を半分失う
                    player()->loseMoney();
                    // バトル終了
                    $this->battleEnd();
                }
                break;
                /******************************************
                * アクション未選択 or 実装されていないアクション
                */
                default:
                // バトル状態が生成されていない場合はエラー
                if(is_null(battle_state())) throw new Exception;
                // 判定不要処理
                battle_state()->judgeFalse();
                // もしどちらかが戦闘不能状態であればバトルを強制終了
                if(
                    enemy()->isFainting() ||
                    !player()->isFightParty()
                ){
                    $this->battleEnd();
                }
                break;
            }
        } catch (Exception $ex) {
            // ホーム画面へ移管
            $_SESSION['__route'] = 'home';
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
        // パーティー取得
        $party = player()->getParty();
        // パーティーのランク補正・状態変化を解除
        array_map(function($partner){
            $partner->initBattleStats();
        }, $party);
        // セッション破棄
        $_SESSION['__data'] = [];
        // 進化フラグのチェック
        $evolves = array_filter($party, function($pokemon){
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
