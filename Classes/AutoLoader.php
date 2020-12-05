<?php
/**
* オートローダー
*/
abstract class AutoLoader
{

    /**
    * 検索するクラスが格納されているフォルダ
    * @var array
    */
    private const FOLDERS = [
        'Move', 'Pokemon', 'Type', 'StatusAilment', 'StateChange', 'Field', 'Item'
    ];

    /**
    * 起動
    * @return void
    */
    public static function init()
    {
        spl_autoload_register(function($class){
            // クラス名からファイルを検索
            foreach(self::FOLDERS as $folder){
                $path = __DIR__ . '/../Classes/'.$folder.'/'.$class.'.php';
                if(file_exists($path)){
                    // 見つかった場合は読み込み実行
                    require $path;
                    break;
                }
            }
        });
    }

}
