<?php
$root_path = __DIR__.'/../../..';
require_once($root_path.'/App/Controllers/Controller.php');

// Initial.php用コントローラー
class InitialController extends Controller
{
    /**
    * ポケモン一覧
    * @var array
    */
    private $pokemon_list = [
        'Fushigidane' => 'フシギダネ',
        'Hitokage' => 'ヒトカゲ',
        'Zenigame' => 'ゼニガメ',
        'Pikachu' => 'ピカチュウ',
        'Mew' => 'ミュウ',
    ];

    /**
    * @return void
    */
    public function __construct()
    {
        // 親コンストラクタの呼び出し
        parent::__construct();
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
        switch ($_POST['action'] ?? '') {
            /**
            * ポケモンの選択
            */
            case 'select_pokemon':
            // ポケモンを生成して引き継ぎデータをセッションに格納
            $class = $_POST['pokemon'];
            if(!isset($this->pokemon_list[$class])){
                $this->setMessage('選択されたポケモンは選ぶことが出来ません');
                break;
            }
            $pokemon = new $class;
            $pokemon->setPosition();
            $_SESSION['__data']['pokemon'] = $pokemon->export();
            // ホーム画面へ移管
            $_SESSION['__route'] = 'home';
            header("Location: ./", true, 307);
            exit;
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
    *
    * @return array
    */
    public function getPokemonList()
    {
        return $this->pokemon_list;
    }
}
