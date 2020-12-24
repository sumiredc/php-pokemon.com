<?php
/**
* ルーティング
*/
abstract class Route
{

    /**
    * リクエストされたページ名の格納
    * @var string
    */
    private static $name = '';

    /**
    * テンプレートパスの格納
    * @var string
    */
    private static $template = '';

    /**
    * コントローラーのパスとクラスの格納
    * @var array
    */
    private static $controller = [];

    /**
    * 認証
    * @return boolean
    */
    public static function auth(): void
    {
        // リクエストされたルートを取得
        self::$name = $_SESSION['__route'] ?? 'initial';
        // トークン認証を実行
        if(
            !isset($_POST['__token']) ||
            !isset($_SESSION['__token']) ||
            $_POST['__token'] !== $_SESSION['__token']
        ){
            // 認証失敗(リロード)
            $_POST = [];
        }
        self::branch();
    }

    /**
    * テンプレートパスとコントローラーの取得
    * @return array
    */
    private static function branch(): void
    {
        // 404ページへのリダイレクト
        if(http_response_code() === 404){
            self::$template = '/Resources/Pages/404.php';
            self::$controller = [
                'dir' => '/App/Controllers/NotFound',
                'class' => 'NotFoundController',
            ];
            return;
        }
        // ページ分岐
        switch (self::$name) {
            // ホーム画面
            case 'home':
            self::$template = '/Resources/Pages/Home.php';
            self::$controller = [
                'dir' => '/App/Controllers/Home',
                'class' => 'HomeController',
            ];
            break;
            // バトル画面
            case 'battle':
            self::$template = '/Resources/Pages/Battle.php';
            self::$controller = [
                'dir' => '/App/Controllers/Battle',
                'class' => 'BattleController',
            ];
            break;
            // 進化画面
            case 'evolve':
            self::$template = '/Resources/Pages/Evolve.php';
            self::$controller = [
                'dir' => '/App/Controllers/Evolve',
                'class' => 'EvolveController',
            ];
            break;
            // ポケモンボックス画面
            case 'pokebox':
            self::$template = '/Resources/Pages/Pokebox.php';
            self::$controller = [
                'dir' => '/App/Controllers/Pokebox',
                'class' => 'PokeboxController',
            ];
            break;
            // デフォルト（初期設定）
            default:
            self::$template = '/Resources/Pages/Initial.php';
            self::$controller = [
                'dir' => '/App/Controllers/Initial',
                'class' => 'InitialController',
            ];
            $_SESSION['__pokemon_ids'] = [];
            break;
        }
    }

    /**
    * テンプレートファイルのパスを返却
    * @return string
    */
    public static function template(): string
    {
        return self::$template;
    }

    /**
    * コントローラーの値を返却
    * @return mixed
    */
    public static function controller($key='')
    {
        // 配列のまま返却
        if(empty($key)){
            return self::$controller;
        }
        // パスを生成して返却
        if($key === 'path'){
            return self::$controller['dir'].'/'.self::$controller['class'].'.php';
        }
        // 指定された値の返却
        if(isset(self::$controller[$key])){
            return self::$controller[$key];
        }
    }

}
