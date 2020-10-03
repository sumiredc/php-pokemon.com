<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/AutoLoader.php');
require_once($root_path.'/Classes/Sanitize.php');
// トレイト
require_once($root_path.'/App/Traits/ResponseTrait.php');
require_once($root_path.'/App/Traits/InstanceTrait.php');

// コントローラー
abstract class Controller
{
    use ResponseTrait;
    use InstanceTrait;

    /**
    * ポケモン格納用
    * @var object
    */
    protected $pokemon;

    /**
    * サニタイズ後のポストデータ格納用
    * @var object
    */
    private $post;

    /**
    * @return void
    */
    public function __construct()
    {
        // オートローダーの起動
        new AutoLoader;
        // サニタイズ
        $sanitize = new Sanitize;
        $this->post = $sanitize->getPost();
    }

    /**
    * @return void
    */
    public function __destruct()
    {
        $_POST = [];
    }

    /**
    * ポケモン情報の取得
    *
    * @return object
    */
    public function getPokemon()
    {
        return $this->pokemon;
    }

    /**
    * リクエストデータの取得
    *
    * @param string
    * @return mixed
    */
    public function request($key='')
    {
        if(empty($key)){
            return $this->post;
        }else{
            return $this->post[$key] ?? '';
        }
    }

}
