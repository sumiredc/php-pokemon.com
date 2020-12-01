<?php
// ルーティング
class Route
{
    /**
    * @var string
    */
    private $name;

    /**
    * テンプレートパスの格納
    * @var string
    */
    private $template = '';

    /**
    * コントローラーのパスとクラスの格納
    * @var array
    */
    private $controller = [];

    /**
    * @return void
    */
    public function __construct($name, $token)
    {
        $this->name = $name;
        if(
            !isset($_POST['__token']) ||
            $_POST['__token'] !== $token
        ){
            $_POST = [];
        }
        // ルートの生成
        $this->route();
    }

    /**
    * @return string
    */
    public function template()
    {
        return $this->template;
    }

    /**
    * コントローラーの値を返却
    * @return mixed
    */
    public function controller($key='')
    {
        if(empty($key)){
            // 配列のまま返却
            return $this->controller;
        }
        // パスを生成して返却
        if($key === 'path'){
            return $this->controller['dir'].'/'.$this->controller['class'].'.php';
        }
        // 指定された値の返却
        if(isset($this->controller[$key])){
            return $this->controller[$key];
        }
    }

    /**
    * テンプレートパスとコントローラーの取得
    * @return array
    */
    public function route(): void
    {
        // 404ページへのリダイレクト
        if(http_response_code() === 404){
            $this->template = '/Resources/Pages/404.php';
            $this->controller = [
                'dir' => '/App/Controllers/NotFound',
                'class' => 'NotFoundController',
            ];
            return;
        }
        /**
        * ページ分岐
        */
        switch ($this->name) {
            // ホーム画面
            case 'home':
            $this->template = '/Resources/Pages/Home.php';
            $this->controller =[
                'dir' => '/App/Controllers/Home',
                'class' => 'HomeController',
            ];
            break;
            // バトル画面
            case 'battle':
            $this->template = '/Resources/Pages/Battle.php';
            $this->controller =[
                'dir' => '/App/Controllers/Battle',
                'class' => 'BattleController',
            ];
            break;
            // 進化画面
            case 'evolve':
            $this->template = '/Resources/Pages/Evolve.php';
            $this->controller =[
                'dir' => '/App/Controllers/Evolve',
                'class' => 'EvolveController',
            ];
            break;
            // ポケモンボックス画面
            case 'pokebox':
            $this->template = '/Resources/Pages/Pokebox.php';
            $this->controller =[
                'dir' => '/App/Controllers/Pokebox',
                'class' => 'PokeboxController',
            ];
            break;
            // デフォルト（初期設定）
            default:
            $this->template = '/Resources/Pages/Initial.php';
            $this->controller =[
                'dir' => '/App/Controllers/Initial',
                'class' => 'InitialController',
            ];
            $_SESSION['__pokemon_ids'] = [];
            break;
        }
    }

}
