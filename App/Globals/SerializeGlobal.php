<?php

/**
* オブジェクトのシリアライズ化
* @param arg:mixed
* @return mixed
*/
function serializeObject($arg)
{
    if(is_array($arg)){
        // 配列の場合はループ
        $result = [];
        foreach($arg as $key => $val){
            $result[$key] = serializeObject($val);
        }
        $arg = $result;
    }else if(is_object($arg)){
        // オブジェクトの場合はシリアライズ
        $arg = ['__serialize' => serialize($arg)];
    }
    return $arg;
}

/**
* オブジェクトのアンシリアライズ化
* @param arg:mixed
* @return mixed
*/
function unserializeObject($arg)
{
    // 配列の処理
    if(is_array($arg)){
        if(
            count($arg) === 1
            && isset($arg['__serialize'])
        ){
            // 配列の中身がシリアライズされたオブジェクトであればオブジェクト化
            $arg = unserialize($arg['__serialize']);
        }else{
            // 通常配列の場合はループ
            $result = [];
            foreach($arg as $key => $val){
                $result[$key] = unserializeObject($val);
            }
            $arg = $result;
        }
    }
    return $arg;
}
