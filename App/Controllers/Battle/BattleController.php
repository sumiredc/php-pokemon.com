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
        // ポケモンの引き継ぎ
        $this->takeOverPokemon($_SESSION['__data']['pokemon']);
        // 敵ポケモンの引き継ぎ
        $this->takeOverEnemy($_SESSION['__data']['enemy'] ?? '');
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
                $this->enemy = $service->getResponse('enemy');
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
                $this->fainting = $service->getResponse('fainting');
                $this->field = $service->getResponse('field');
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
                if(!$service->getResponse('result')){
                    // 失敗
                    $this->fainting = $service->getResponse('fainting');
                    $this->field = $service->getResponse('field');
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
            // メッセージとレスポンスとモーダルをコントローラーへ引き継ぎ
            if(isset($service)){
                $this->setMessage($service->getMessages());
                $this->setResponse($service->getResponses());
                $this->setModal($service->getModals(), true);
                $service->resetAll();
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
        // 破棄
        unset(
            $_SESSION['__data']['enemy'],
            $_SESSION['__data']['rank'],
            $_SESSION['__data']['sc'],
            $_SESSION['__data']['run'],
            $_SESSION['__data']['field']
        );
        $_SESSION['__route'] = 'home';
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
            $this->setMessage('行動を選択してください');
            return false;
        }
    }

}
