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
* @return string|integer
*/
function getPageName(bool $prefix=false)
{
    // 404ページ
    if(http_response_code() === 404){
        return 404;
    }
    // ページ名を全て小文字に変換
    $page = strtolower($_SESSION['__route'] ?? 'initial');
    // 最初の文字を大文字に変換
    if($prefix){
        $page = ucfirst($page);
    }
    // ページ名を返却
    return $page;
}

/**
* ゼロ埋め処理
* @param number:integer
* @param length:integer
* @return string
*/
function fillZero($number, $length=3)
{
    // ゼロ埋め
    $zero = '';
    // ゼロ必要数の算出
    $zero_count = $length - strlen($number);
    for ($i=0; $i < $zero_count; $i++) {
        $zero = $zero.'0';
    }
    // ゼロ埋め返却
    return $zero.$number;
}

/**
* デバック用
* @param arg:mixed
* @return void
*/
function dd($arg)
{
    echo '<pre>';
    var_export($arg);
    echo '</pre>';
}
