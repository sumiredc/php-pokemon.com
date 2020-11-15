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
