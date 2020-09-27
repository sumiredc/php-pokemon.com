<?php

class AutoLoader
{

    /**
    * 検索するクラスが格納されているフォルダ
    * @return void
    */
    private $folders = [
        'Move', 'Pokemon', 'Type', 'StatusAilment', 'StateChange',
    ];

    /**
    * オートローダー
    *
    * @return void
    */
    public function __construct()
    {
        spl_autoload_register([$this, 'autoLoader']);
    }

    /**
    * コールバック用メソッド
    *
    * @return void
    */
    private function autoLoader($class_name)
    {
        // クラス名からファイルを検索
        foreach($this->folders as $folder){
            $path = __DIR__ . '/../Classes/'.$folder.'/'.$class_name.'.php';
            if(file_exists($path)){
                // 見つかった場合は読み込み実行
                require $path;
                break;
            }
        }
    }
}
