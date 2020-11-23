<?php
$root_path = __DIR__.'/../../..';
require_once($root_path.'/App/Controllers/Controller.php');
// サービス
require_once($root_path.'/App/Services/Battle/StartService.php');
require_once($root_path.'/App/Services/Battle/RunService.php');
require_once($root_path.'/App/Services/Battle/FightService.php');
require_once($root_path.'/App/Services/Battle/ItemService.php');
require_once($root_path.'/App/Services/Battle/ChangeService.php');
require_once($root_path.'/App/Services/Battle/LearnMoveService.php');
// トレイト
require_once($root_path.'/App/Traits/Controller/BattleControllerTrait.php');

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
        // デストラクタ直前のチェック処理
        $this->checkBeforeDestruct();
        // 次画面へ送るデータ
        $_SESSION['__data']['battle_state'] = serializeObject(battle_state());
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
            switch (request('action')) {
                /******************************************
                * 開始
                */
                case 'battle':
                // サービス実行
                $service = new StartService;
                $service->execute();
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
                * アクション未選択 or 実装されていないアクション
                */
                default:
                // もしどちらかが戦闘不能状態であればバトルを強制終了
                if(
                    battle_state()->isFainting()
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
        // パーティー取得
        $party = player()->getParty();
        // パーティーのランク補正・状態変化を解除
        array_map(function($partner){
            $partner->releaseBattleStatsAll();
        }, $party);
        // セッション破棄
        $keys = [
            'battle_state', 'before_responses', 'before_messages', 'before_modals'
        ];
        foreach($keys as $key){
            unset($_SESSION['__data'][$key]);
        }
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
