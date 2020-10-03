<?php
// ルーティング
class Route
{
    /**
    * @var string
    */
    private $name;

    /**
    *
    * @return void
    */
    public function __construct($name, $token)
    {
        $this->name = $name;
        if(
            !isset($_POST['__token']) ||
            ($_POST['__token'] !== $token)
        ){
            $_POST = [];
        }
    }

    /**
    * テンプレートパス取得
    * @return string
    */
    public function template():string
    {
        switch ($this->name) {
            // ホーム画面
            case 'home':
            $path = '/Resources/Pages/Home.php';
            break;
            // バトル画面
            case 'battle':
            $path = '/Resources/Pages/Battle.php';
            break;
            // デフォルト（初期設定）
            default:
            $path = '/Resources/Pages/Initial.php';
            break;
        }
        // テンプレートパスを返却
        return $path;
    }

}
