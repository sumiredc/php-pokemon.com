<?php
require_once app_path('Services/Service.php');

/**
* ゲーム開始用サービス
*/
class SelectPokemonService extends Service
{

    /**
    * @var boolean
    */
    protected $auth = false;

    /**
    * @var 管理者モード
    */
    protected $admin = 'ポケモンマスター';

    /**
    * @return void
    */
    public function __construct()
    {
        //
    }

    /**
    * @return void
    */
    public function execute()
    {
        // 入力値の検証
        if(!$this->validation()){
            $this->auth = false;
            return;
        }
        // 管理者用の分岐
        if(
            request('name') === $this->admin &&
            (int)request('pokemon') === 3
        ){
            // 管理者モード（ポケモンマスター）
            $this->pokemonMaster();
        }else{
            // 通常トレーナー
            initPlayer(request('name'));
            $class = config('const.first_pokemon.'.request('pokemon'));
            $pokemon = new $class(5);
            $pokemon->setPosition();
            player()->setParty($pokemon);
            // 初期アイテム
            player()->addItem('ItemPotion', 5);     # キズぐすり
            player()->addItem('ItemPokeBall', 5);   # モンスターボール
        }
        // ポケモンボックスの初期化
        initPokebox();
        // データの作成成功
        $this->auth = true;
    }

    /**
    * 認証結果の返却
    * @return boolean
    */
    public function auth(): bool
    {
        return $this->auth;
    }

    /**
    * バリデーション
    * @return boolean
    */
    private function validation(): bool
    {
        // 管理者権限
        if(
            request('name') === $this->admin &&
            (int)request('pokemon') === 3
        ){
            return true;
        }
        // プレイヤー名の確認
        if(!request('name')){
            response()->setMessage('プレイヤーの名前を入力してください');
            return false;
        }
        // 文字数
        if(mb_strlen(request('name')) > 5){
            response()->setMessage('プレイヤーの名前は５文字以内で入力してください');
            return false;
        }
        // ポケモンの確認
        if(!config('const.first_pokemon.'.request('pokemon'))){
            response()->setMessage('選択されたポケモンは選ぶことが出来ません');
            return false;
        }
        // 検証成功
        return true;
    }


    /**
    * ポケモンマスター（管理者モード）の作成
    * @return void
    */
    private function pokemonMaster(): void
    {
        initPlayer('レッド');
        // ミュウの作成
        $mew = new Mew(10);
        $mew->setNickname('デバッガー');
        $mew->setPosition();
        player()->setParty($mew);
        // 全てのポケモンをパーティーにセット
        foreach(config('const.first_pokemon') as $class){
            $pokemon = new $class(10);
            $pokemon->setPosition();
            player()->setParty($pokemon);
        }
        // プレイヤーレベルを90にする
        for ($i=1; $i < 10; $i++) {
            player()->levelUp();
        }
        // 初期アイテム
        player()->addItem('ItemPotion', 20);
        player()->addItem('ItemPokeBall', 20);
        player()->addItem('ItemMasterBall', 50);
        player()->addItem('ItemXAttack', 50);
        // player()->addItem('ItemThunderStone', 50);
        // おこづかい
        player()->addMoney(10000);
    }

}
