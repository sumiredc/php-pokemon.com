<?php
$root_path = __DIR__.'/../../..';
require_once($root_path.'/App/Controllers/Controller.php');

// 初期画面用コントローラー
class InitialController extends Controller
{
    /**
    * 最初のポケモン
    * @var array
    */
    private $pokemon_list;

    /**
    * @return void
    */
    public function __construct()
    {
        // 親コンストラクタの呼び出し
        parent::__construct();
        $this->pokemon_list = config('const.first_pokemon');
        // 本番環境用の分岐
        if(@$_SERVER['SERVER_NAME'] === 'php-pokemon.com.local'){
            // ミュウはローカルのみ
            $this->pokemon_list['Mew'] = 'ミュウ';
        }
        // 分岐処理
        $this->branch();
        // 親デストラクタの呼び出し
        parent::__destruct();
    }

    /**
    * アクションに合わせた分岐
    * @return void
    */
    private function branch()
    {
        switch (request('action')) {
            /**
            * ポケモンの選択
            */
            case 'select_pokemon':
            // プレイヤー名の確認
            if(!request('name')){
                setMessage('プレイヤーの名前を入力してください');
                break;
            }
            if(mb_strlen(request('name')) > 5){
                setMessage('プレイヤーの名前は５文字以内で入力してください');
                break;
            }
            // ポケモンを生成して引き継ぎデータをセッションに格納
            $class = request('pokemon');
            // バリデーション
            if(!isset($this->pokemon_list[$class])){
                setMessage('選択されたポケモンは選ぶことが出来ません');
                break;
            }
            // プレイヤー作成
            initPlayer(request('name'));
            // 環境分岐
            if(@$_SERVER['SERVER_NAME'] === 'php-pokemon.com.local'){
                $this->developOnly($class);
            }else{
                // 通常環境
                $pokemon = new $class(5);
                $pokemon->setPosition();
                player()->setParty($pokemon);
                // 初期アイテムをセット
                player()->addItem(new ItemPotion, 5);
                player()->addItem(new ItemPokeBall, 5);
            }
            // ポケモンボックスの初期化
            initPokebox();
            // ホーム画面へ移管
            $_SESSION['__route'] = 'home';
            $_SESSION['__start_php_pokemon'] = true;
            // 画面移管
            $this->redirect();
            break;
            /**
            * アクション未選択 or 実装されていないアクション
            */
            default:
            // 初期化
            $_SESSION = [];
            $_SESSION['__token'] = bin2hex(openssl_random_pseudo_bytes(32));
            break;
        }
    }

    /**
    * ポケモン一覧の取得
    * @return array
    */
    public function getPokemonList()
    {
        return $this->pokemon_list;
    }

    /**
    * 開発環境のみで行う処理
    * @param class:string
    * @return void
    */
    private function developOnly($class)
    {
        // // 通常処理
        // $pokemon = new $class(5);
        // $pokemon->setPosition();
        // player()->setParty($pokemon);

        // 全てのポケモンをパーティーにセット
        foreach($this->pokemon_list as $class => $name){
            $pokemon = new $class(5);
            $pokemon->setPosition();
            if($class === 'Mew'){
                $pokemon->setNickname('デバッガー');
            }
            player()->setParty($pokemon);
        }

        // // ニャースを追加
        // $pokemon = new Nyarth(5);
        // $pokemon->setPosition();
        // player()->setParty($pokemon);

        // 初期アイテムをセット
        player()->addItem(new ItemPotion, 20);
        player()->addItem(new ItemPokeBall, 20);
        player()->addItem(new ItemMasterBall, 50);
    }
}
