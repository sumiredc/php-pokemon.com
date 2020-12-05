<?php
// config取得用グローバル関数
function config(string $dot_key)
{
    $keys = explode('.', $dot_key);
    $config = include(root_path().'/Config/'.$keys[0].'.php');
    unset($keys[0]);
    foreach($keys ?? [] as $key){
        $config = $config[$key] ?? null;
        // 配列でなくなればループ終了
        if(!is_array($config)){
            break;
        }
    }
    return $config;
}
