<?php
// クラス読み込み
require_once($root_path.'/Classes/Request.php');
$global_request = new Request;
/**
* 送信された値の取得
* @param dot_key:string
* @return mixed
*/
function request($dot_key='')
{
    global $global_request;
    return $global_request->request($dot_key);
}
