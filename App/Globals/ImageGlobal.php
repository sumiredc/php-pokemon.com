<?php
/**
* base64形式のポケモン画像取得
* @param pokemon:string
* @param pause:string::front|back|mini
* @return string::data:base64
*/
function base64_pokemon(string $pokemon, string $pause='front')
{
    // 画像の取得処理
    $base64 = base64_encode(
        @file_get_contents(storage_path('Images/Pokemon/'.$pokemon).$pause.'.gif')
    );
    if($base64){
        $info = getimagesize('data:application/octet-stream;base64,' . $base64);
        return 'data: '.$info['mime'].';base64,'.$base64;
    }else{
        return config('notfound.'.$pause) ?? config('notfound.mini');
    }
}

/**
* Storageに存在する画像をbase64形式で取得する関数
* @param path:string
* @return string::data:base64
*/
function base64_storage($path)
{
    // 画像の取得処理
    $base64 = base64_encode(
        @file_get_contents(storage_path('Images').$path)
    );
    if($base64){
        $info = getimagesize('data:application/octet-stream;base64,' . $base64);
        return 'data: '.$info['mime'].';base64,'.$base64;
    }else{
        return config('notfound.mini');
    }
}
