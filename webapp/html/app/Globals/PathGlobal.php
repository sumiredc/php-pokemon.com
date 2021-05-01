<?php
/**
* rootパスの取得
* @param string $path
* @return string
*/
function root_path(string $path=''): string
{
    return preg_replace("/app\/Globals\/PathGlobal\.php$/", '', __FILE__).$path;
}

/**
* appパスの取得
* @param string $path
* @return string
*/
function app_path(string $path=''): string
{
    return root_path('app/'.$path);
}

/**
* storageパスの取得
* @param string $path
* @return string
*/
function storage_path(string $path=''): string
{
    return root_path('storage/'.$path);
}

/**
* Resourcesパスの取得
* @param string $path
* @return string
*/
function resources_path(string $path=''): string
{
    return root_path('resources/'.$path);
}

/**
* publicパスの取得
* @param string $path
* @return string
*/
function public_path(string $path=''): string
{
    return root_path('public/'.$path);
}

/**
* public/assetsパスの取得
* @param string $path
* @return string
*/
function assets_path(string $path=''): string
{
    return root_path('public/assets/'.$path);
}

// URI

/**
* ルートURIの取得
* @param string $path
* @return string
*/
function root_uri(string $path=''): string
{
    return (empty($_SERVER['HTTPS']) ? 'http://' : 'https://').$_SERVER['HTTP_HOST'].'/'.$path;
}

/**
* ルートURIの取得
* @param string $path
* @return string
*/
function assets_uri(string $path=''): string
{
    return root_uri('assets/'.$path);
}
