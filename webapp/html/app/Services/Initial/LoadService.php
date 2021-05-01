<?php
require_once app_path('Services/Service.php');

/**
* セーブデータの読み込み
*/
class LoadService extends Service
{

    /**
    * @var boolean
    */
    protected $auth = false;

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
        if($this->load()){
            // データの作成成功
            $this->auth = true;
        }else{
            response()->setMessage('セーブデータの読み込みに失敗しました');
        }
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
    * データの読み込み
    * @return boolean
    */
    private function load(): bool
    {
        try {
            // プレイヤーの一覧を取得
            $players = file(storage_path('database/players.csv'));
            $players = array_map(function($id){
                return preg_replace('/\n/', '', $id) === request('player_id');
            }, $players);
            // プレイヤーデータの存在確認
            if(empty($players)){
                throw new Exception;
            }
            // レポートファイルのパスを取得
            $report = storage_path('database/reports/'.request('player_id'));
            // レポートの存在確認
            if(!file_exists($report)){
                throw new Exception;
            }
            // セーブデータを現在のセッションへ読み込み
            session_decode(
                file($report)[0]
            );
            // セッションを保存
            session_write_close();
            // セーブデータの読み込み完了
            return true;
        } catch (Exception $ex) {
            // セーブデータの読み込み失敗
            return false;
        }
    }

}
