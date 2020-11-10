<?php
// config取得用グローバル関数
function config(string $dot_key)
{
    $root_path = __DIR__.'/../..';
    $keys = explode('.', $dot_key);
    $config = include($root_path.'/Config/'.$keys[0].'.php');
    unset($keys[0]);
    foreach($keys ?? [] as $key){
        $config = $config[$key];
    }
    return $config;
}
