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





    /**
    * アクション
    *
    * @param string $action
    * @param mixed $param
    * @return void
    */
    private function action($action, $param)
    {
        // // AIで技選択
        // $ai = $this->aiSelectMove();
        // // 敵の技をインスタンス化
        // $e_move = new $ai['class']($ai['remaining'], $ai['correction']);
        switch ($action) {
            // /**
            // * にげる
            // */
            // case 'run':
            // $this->run++;
            // if($this->checkRun()){
            //     $this->endBattle();
            // }
            // $this->setMessage('逃げられない！');
            // // 敵ポケモンの攻撃
            // $p_damage = $this->attack($this->enemy, $this->pokemon, $e_move);
            // break;
            /**
            * たたかう
            */
            // case 'fight':
            // // 自ポケモンの技をインスタンス化
            // if($param === ''){
            //     // 技が未選択の場合は「わるあがき」をセット
            //     $p_move = new Struggle;
            // }else{
            //     $p_move = $this->pokemon
            //     ->getMove($param);
            // }
            //
            // // 行動順の判定
            // $order_array = $this->orderMove(
            //     [$this->pokemon, $this->enemy, $p_move],
            //     [$this->enemy, $this->pokemon, $e_move],
            // );
            // // 行動順にforeachでattackメソッドを実行
            // foreach($order_array as list($atk, $def, $move)){
            //     $this->attack($atk, $def, $move);
            //     // ひんしチェック
            //     if($this->setToCheckFainting($def, $atk)){
            //         // ひんしポケモン有り
            //         break 2;
            //     }
            // }
            // // 行動順にforeachでcheckAfterSaとcheckAfterScを実行
            // foreach($order_array as list($atk, $def, $move)){
            //     $this->checkAfterSa($atk);
            //     $this->checkAfterSc($atk, $def);
            //     // ひんしチェック
            //     if($this->setToCheckFainting($def, $atk)){
            //         // ひんしポケモン有り
            //         break 2;
            //     }
            // }
            // break;
        } #endswitch

        // // ひんしポケモンがでた場合の処理
        // if($this->fainting['enemy'] || $this->fainting['friend']){
        //     $this->judgment();
        //     return;
        // }
        // // チャージ中なら再度アクション実行
        // if($this->chargeNow()){
        //     $this->action($action, $param);
        // }else{
        //     $this->setMessage('行動を選択してください');
        // }
    }

    // /**
    // * 行動順の判定
    // * （行動順判定用数値を生成）
    // * @var 100万の位：優先度
    // * @var 10〜10万の位：すばやさ
    // * @var 1の位：乱数
    // * @param array [攻撃ポケモン, 防御ポケモン, 攻撃ポケモンの技]
    // * @return array [行動順判定用数値 => [攻撃ポケモン, 防御ポケモン, 技],...]
    // */
    // private function orderMove(...$pokemons)
    // {
    //     $results = [];
    //     foreach($pokemons as list($atk, $def, $move)){
    //         // 優先度のセット
    //         $speed = $move->getPriority() * 1000000;
    //         // 素早さ実数値の加算
    //         $speed += $atk->getStats('Speed', true) * 10;
    //         // 乱数の生成(同速判定用)
    //         $key = $speed + random_int(0, 9);
    //         // 重複回避
    //         while(isset($results[$key])){
    //             $key = $speed + random_int(0, 9);
    //         }
    //         // 配列へセット
    //         $results[$key] = [$atk, $def, $move];
    //     }
    //     // 降順（行動が早い順）に並び替え
    //     krsort($results);
    //     // [行動順判定用数値 => [ポケモン => 技],...] の多次元配列で返却
    //     return $results;
    // }


    // /**
    // * 行動不可（チャージ中）の判定
    // *
    // * @return boolean (true:行動不可, false:行動可)
    // */
    // private function chargeNow()
    // {
    //     $sc = $this->pokemon
    //     ->getSc();
    //     // チャージ中なら行動選択不可
    //     if(isset($sc['ScCharge'])){
    //         return true;
    //     }else{
    //         return false;
    //     }
    // }

    // /**
    // * ひんし状態の格納
    // *
    // * @return boolean (true:ひんしポケモン有り, false:ひんしポケモン無し)
    // */
    // private function setToCheckFainting($def, $atk)
    // {
    //     // 防御側のひんし状態を格納
    //     $this->fainting[$def->getPosition()] = $this->checkFainting($def);
    //     // 攻撃側のひんし状態を格納
    //     $this->fainting[$atk->getPosition()] = $this->checkFainting($atk);
    //     // 返り値判定
    //     if($this->fainting['enemy'] || $this->fainting['friend']){
    //         return true;
    //     }
    //     return false;
    // }

    // /**
    // * バトル結果判定
    // *
    // * @return void
    // */
    // private function judgment()
    // {
    //     if($this->fainting['friend']){
    //         // 味方がひんし状態になった
    //         $this->setMessage('目の前が真っ暗になった');
    //     }else{
    //         // 相手がひんし状態になった（味方はひんし状態ではない）
    //         // 経験値の計算
    //         $exp = $this->calExp($this->pokemon, $this->enemy);
    //         // 経験値をポケモンにセット(返り値をpokemonに格納)
    //         $this->pokemon = $this->pokemon
    //         ->setExp($exp);
    //         // 努力値を獲得
    //         $this->pokemon
    //         ->setEv($this->enemy->getRewardEv());
    //         // ポケモンに溜まったメッセージを取得
    //         $this->setMessage($this->pokemon->getMessages());
    //     }
    //     // バトル終了判定用メッセージの格納
    //     $this->setMessage(' ', 'battle-end');
    // }

    // /**
    // * バトル終了
    // *
    // * @return void
    // */
    // private function endBattle()
    // {
    //     unset($_SESSION['enemy']);
    //     unset($_SESSION['rank']);
    //     unset($_SESSION['sc']);
    //     unset($_SESSION['run']);
    //     header("Location: ./home.php", true, 307);
    //     exit;
    // }

    // /**
    // * 経験値の計算
    // * (EXP × LM^2.5 + 1)
    // *
    // * @var EXP 倒されたポケモンのレベル × 倒されたポケモンの基礎経験値 ÷ 5
    // * @var LM レベル補正 (2L + 10) / (L + Lp + 10)
    // * @var L 倒されたポケモン($lose)のレベル
    // * @var Lp 倒したポケモン($win)のレベル
    // *
    // * @param object $win Pokemon
    // * @param object $lose Pokemon
    // * @return integer
    // */
    // protected function calExp($win, $lose)
    // {
    //     // EXP
    //     $exp = $lose->getLevel() * $lose->getBaseExp() / 5;
    //     // レベル補正
    //     $lm = (2 * $lose->getLevel() + 10) / ($lose->getLevel() + $win->getLevel() + 10);
    //     // 経験値の計算結果を整数（切り捨て）で返却
    //     return (int)($exp * $lm ** 2.5 + 1);
    // }

}
