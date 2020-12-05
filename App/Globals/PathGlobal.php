<?php
/**
* rootパスの取得
* @param path:string::ドット記法対応
* @return string
*/
function root_path(string $path='/')
{
    // 引数で相対パスの指定があれば、前後にスラッシュを追加してpreg_replaceで置き換え
    if($path !== '/'){
        $path = preg_replace("/\./", '/', '.'.$path.'.');
    }
    return preg_replace("/\/App\/Globals\/PathGlobal\.php$/", '', __FILE__).$path;
}

/**
* appパスの取得
* @param path:string::ドット記法対応
* @return string
*/
function app_path(string $path='')
{
    return root_path('App.'.$path);
}

/**
* Storageパスの取得
* @param path:string::ドット記法対応
* @return string
*/
function storage_path(string $path='')
{
    return root_path('Storage.'.$path);
}

/**
* Resourcesパスの取得
* @param path:string::ドット記法対応
* @return string
*/
function resources_path(string $path='')
{
    return root_path('Resources.'.$path);
}

/**
* publicパスの取得
* @param path:string::ドット記法対応
* @return string
*/
function public_path(string $path='')
{
    return root_path('Public.'.$path);
}

/**
* public/Assetsパスの取得
* @param path:string::ドット記法対応
* @return string
*/
function assets_path(string $path='')
{
    return root_path('Public.Assets.'.$path);
}
