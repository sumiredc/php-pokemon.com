<?php
$root_path = __DIR__.'/../../..';
require_once($root_path.'/App/Controllers/Controller.php');
// サービス
require_once($root_path.'/App/Services/Battle/StartService.php');
require_once($root_path.'/App/Services/Battle/RunService.php');
require_once($root_path.'/App/Services/Battle/FightService.php');
// トレイト
require_once($root_path.'/App/Traits/Controller/BattleControllerTrait.php');

// バトル用コントローラー
class BattleController extends Controller
{

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
    * ひんし状態の格納
    * @var array
    */
    private $fainting = [
        'friend' => false,
        'enemy' => false,
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
        // 次のターンへの分岐
        $this->nextTurn();
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
        if(isset($_SESSION['run'])){
            $this->run = $_SESSION['run'];
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
                $service = new StartService;
                $service->excute();
                // 実行結果
                $this->enemy = $service->getResponse('enemy');
                $this->setMessage($service->getMessages());
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
                );
                $service->excute();
                // 実行結果
                $this->fainting = $service->getResponse('fainting');
                $this->setMessage($service->getMessages());
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
                    $this->run
                );
                $service->excute();
                // 実行結果
                if($service->getResponse('result')){
                    // 成功
                    $this->setMessage($service->getMessages());
                    $_SESSION['__route'] = 'home';
                    // 破棄
                    unset(
                        $_SESSION['__data']['enemy'],
                        $_SESSION['__data']['rank'],
                        $_SESSION['__data']['sc'],
                        $_SESSION['__data']['run']
                    );
                    header("Location: ./", true, 307);
                    exit;
                }else{
                    // 失敗
                    $this->fainting = $service->getResponse('fainting');
                    $this->setMessage($service->getMessages());
                }
                break;
                /******************************************
                * バトル終了
                */
                case 'end':
                $_SESSION['__route'] = 'home';
                header("Location: ./", true, 307);
                exit;
                break;
                /******************************************
                * アクション未選択 or 実装されていないアクション
                */
                default:
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
    * 次のターンへの判定処理
    *
    * @return void
    */
    private function nextTurn()
    {
        // ひんしポケモンがでた場合の処理
        if($this->fainting['enemy'] || $this->fainting['friend']){
            $this->judgment();
            return;
        }
        // チャージ中なら再度アクション実行
        if($this->chargeNow()){
            $this->branch();
        }else{
            $this->setMessage('行動を選択してください');
        }
    }

}
