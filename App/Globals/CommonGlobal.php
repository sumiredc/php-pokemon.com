<?php
/**
* 名称翻訳
* @param str:string
* @param key:string|integer
* @return string
*/
function transJp($str, $key=0)
{
    $array = config('ja.'.$key);
    // 小文字変換して配列から取得、存在しなければそのまま返却
    return $array[mb_strtolower($str)] ?? $str;
}

/**
* 現在のページ名プレフィックスを取得
* @param prefix:bool
* @return string
*/
function getPageName(bool $prefix=false)
{
    // ページ名を全て小文字に変換
    $page = strtolower($_SESSION['__route'] ?? 'initial');
    // 最初の文字を大文字に変換
    if($prefix){
        $page = ucfirst($page);
    }
    // ページ名を返却
    return $page;
}
