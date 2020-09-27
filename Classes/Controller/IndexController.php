<?php
require_once(__DIR__.'/../Controller.php');

// Index.php用コントローラー
class IndexController extends Controller
{
    /**
    * ポケモン一覧
    * @var array
    */
    private $pokemon_list = [
        'Pikachu' => 'ピカチュウ',
        'Fushigidane' => 'フシギダネ',
        'Hitokage' => 'ヒトカゲ',
        'Zenigame' => 'ゼニガメ',
        'Mew' => 'ミュウ',
    ];

    /**
    * @return void
    */
    public function __construct()
    {
        // 親コンストラクタの呼び出し
        parent::__construct();
        if(isset($_POST['pokemon']) && !empty($_POST['pokemon'])){
            // POSTを含めたリダイレクト
            header("Location: ./home.php", true, 307) ;
            exit;
        }else{
            // 初期化
            $_POST = [];
            $_SESSION = [];
            $this->setMessage('ポケモンを選択してください');
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
