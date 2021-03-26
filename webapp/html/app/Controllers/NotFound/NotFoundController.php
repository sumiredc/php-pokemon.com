<?php
require_once app_path('Controllers/Controller.php');

// 404ページ用コントローラー
class NotFoundController extends Controller
{

    /**
    * プレイヤー情報の有無
    * @var boolean
    */
    private $player_flg = false;

    /**
    * コイキング
    * @var string
    */
    private $koiking = '404';

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
    * 分岐
    * @return void
    */
    private function branch(): void
    {
        // プレイヤー情報の存在確認
        if(player()){
            player()->pokedex()->discovery('Koiking');
            $this->player_flg = true;
            // コイキング画像の準備
            if(!random_int(0, 8192)){
                // 色違い
                $this->koiking .= 'shiny';
            }
        }
    }

    /**
    * プレイヤー情報の有無
    * @return boolean
    */
    public function isPlayer(): bool
    {
        return $this->player_flg;
    }

    /**
    * コイキング画像の取得
    * @return string
    */
    public function koiking(): string
    {
        return $this->koiking;
    }

}
