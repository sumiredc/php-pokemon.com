<?php
/**
* オートローダー
*/
class AutoLoader
{

    /**
    * 検索するクラスが格納されているフォルダ
    * @var array
    */
    private const FOLDERS = [
        'Move', 'Pokemon', 'Type', 'StatusAilment', 'StateChange', 'Field', 'Item'
    ];

    /**
    * オートローダーの実行
    * @return void
    */
    public function __construct()
    {
        spl_autoload_register([$this, 'autoLoader']);
    }

    /**
    * コールバック用メソッド
    * @return void
    */
    private function autoLoader(string $class_name): void
    {
        // クラス名からファイルを検索
        foreach(self::FOLDERS as $folder){
            $path = __DIR__ . '/../Classes/'.$folder.'/'.$class_name.'.php';
            if(file_exists($path)){
                // 見つかった場合は読み込み実行
                require $path;
                break;
            }
        }
    }
    
}
