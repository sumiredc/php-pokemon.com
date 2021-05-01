<?php
require_once app_path('Services/Service.php');

/**
* レポート
*/
class ReportService extends Service
{

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
        if($this->save()){
            response()->setMessage('レポートにしっかり書き込みました');
        }else{
            response()->setMessage('レポートの書き込みに失敗しました');
        }
    }

    /**
    * データの保存
    * @return boolean
    */
    private function save(): bool
    {
        // プレイヤーID生成前のユーザーは保存不可
        if(empty(player()->getId())){
            response()->setMessage('メニュー > 「'.player()->getName().'」よりIDを生成してください');
            return false;
        }
        // レポートファイルのパスを取得
        $report = storage_path('database/reports/'.player()->getId());
        try {
            // ファイルの存在確認(なければ作成)
            if(!file_exists($report)){
                touch($report);
            }
            // 書き込みモードでファイルを開く
            $file = fopen($report, 'w');
            // ファイルに書き込む
            fwrite($file, session_encode());
            // ファイルを閉じる
            fclose($file);
            // 最終保存日時を更新
            player()->setSavedAt();
            // レポート完了
            return true;
        } catch (Exception $ex) {
            // レポート失敗
            return false;
        }
    }

}
