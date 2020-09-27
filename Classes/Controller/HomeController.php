<?php
require_once(__DIR__.'/../Controller.php');

// ホーム用コントローラー
class HomeController extends Controller
{

    /**
    * @return void
    */
    public function __construct()
    {
        // 親コンストラクタの呼び出し
        parent::__construct();
        /**
        * ポケモンが選択された
        */
        if(isset($_POST['pokemon'])){
            $this->checkPokemon(htmlspecialchars($_POST['pokemon']));
            return;
        }
        /**
        * アクションが実行された
        */
        if(isset($_POST['action'])){
            // 引き継いだデータを引数にポケモンをインスタンス化
            $this->pokemon = $this->getPokemonInstance($_SESSION['pokemon']['class_name'], $_SESSION['pokemon']);
            // アクションメソッドの実行
            $this->action(htmlspecialchars($_POST['action']), htmlspecialchars($_POST['param'] ?? null));
            return;
        }
        /**
        * アクションが実行されていない（更新が押された）
        */
        // 引き継いだデータを引数にポケモンをインスタンス化
        $this->pokemon = $this->getPokemonInstance($_SESSION['pokemon']['class_name'], $_SESSION['pokemon']);
    }

    /**
    * ポケモンのインスタンス化
    *
    * @param string $pokemon(class_name)
    * @var void
    */
    private function getPokemonInstance($class_name, $data)
    {
        return new $class_name($data);
    }

    /**
    * ポケモンクラスの存在チェック
    *
    * @param string $pokemon(class_name)
    * @var void
    */
    private function checkPokemon($pokemon)
    {
        if(class_exists($pokemon)){
            $this->pokemon = new $pokemon;
            // Pokemonのインスタンスに溜まったメッセージを取得
            $this->setMessage($this->pokemon->getName().'をゲットした！', 'success');
            // ポケモンの立場を味方にする
            $this->pokemon
            ->setPosition();
        }else{
            $this->setMessage('選択されたポケモンは存在しません', 'error');
        }
    }

    /**
    * アクション
    *
    * @param string $action(method_name)
    * @param mixed $param
    * @return void
    */
    private function action($action, $param)
    {
        // リセットの処理
        if($action === 'reset' || is_null($this->pokemon)){
            header("Location: ./index.php", true, 307) ;
            exit;
        }
        // にげるの処理
        if($action === 'run'){
            $this->setMessage('上手く逃げ切れた', 'success');
            return;
        }
        // バトル終了
        if($action === 'end'){
            if($this->pokemon->getRemainingHp() <= 0){
                // ひんし状態ならHPを全回復させる
                $this->pokemon
                ->calRemainingHp('reset');
            }
            return;
        }
        // 呼び出せるメソッドか判別
        if(is_callable([$this->pokemon, $action])){
            // メソッド実行結果を$resultに格納
            $result = $this->pokemon
            ->$action($param);
            switch ($action) {
                // 経験値の取得
                case 'setExp':
                $this->pokemon = $result;
                break;
            }
            // Pokemonクラスに溜まったメッセージを取得
            $this->setMessage($this->pokemon->getMessages());
        }else{
            $this->setMessage('このアクションは使用できません', 'error');
        }
    }

}
