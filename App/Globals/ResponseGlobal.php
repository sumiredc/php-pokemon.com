<?php
// レスポンス用グローバル関数
$root_path = __DIR__.'/../..';
// クラス読み込み
require_once($root_path.'/Classes/Response.php');
$global_responses = new Response;

/**
* メッセージIDの発行
* @return string
*/
function issueMsgId()
{
    global $global_responses;
    $name = __FUNCTION__;
    return $global_responses->$name();
}

/**
* 使用中のメッセージIDを格納
*
* @return string
*/
function setUsedMessageId($arg)
{
    global $global_responses;
    $name = __FUNCTION__;
    return $global_responses->$name($arg);
}

/**
* 全リセット
* @return void
*/
function resetResponsesAll()
{
    global $global_responses;
    $name = __FUNCTION__;
    $global_responses->$name();
}

/**==================================================================
* メッセージ関係の処理
==================================================================**/
/**
* メッセージの取得
* @return array
*/
function getMessages()
{
    global $global_responses;
    $name = __FUNCTION__;
    return $global_responses->$name();
}

/**
* メッセージの格納
* @param string|array $msg
* @param mixed $param
* @return void
*/
function setMessage($msg, $param=null)
{
    global $global_responses;
    $name = __FUNCTION__;
    $global_responses->$name($msg, $param);
}

/**
* アニメーション用の自動メッセージの格納
*
* @param mixed $param
* @return void
*/
function setAutoMessage($param)
{
    global $global_responses;
    $name = __FUNCTION__;
    $global_responses->$name($param);
}

/**
* 空メッセージの格納
*
* @param string $param
* @return void
*/
function setEmptyMessage(string $param='')
{
    global $global_responses;
    $name = __FUNCTION__;
    $global_responses->$name($param);
}

/**
* メッセージの初期化
* @return void
*/
function resetMessage()
{
    global $global_responses;
    $name = __FUNCTION__;
    $global_responses->$name();
}

/**
* メッセージの最初のキーを取得
*
* @return mixed
*/
function getMessageFirstKey()
{
    global $global_responses;
    $name = __FUNCTION__;
    return $global_responses->$name();
}

/**
* メッセージの最後のキーを取得
*
* @return mixed
*/
function getMessageLastKey()
{
    global $global_responses;
    $name = __FUNCTION__;
    return $global_responses->$name();
}

/**==================================================================
* レスポンス関係の処理
==================================================================**/
/**
* 指定したレスポンステータの取得
*
* @param string|integer
* @return mixed
*/
function getResponse($param)
{
    global $global_responses;
    $name = __FUNCTION__;
    return $global_responses->$name($param);
}

/**
* レスポンステータの全取得
*
* @return array
*/
function getResponses()
{
    global $global_responses;
    $name = __FUNCTION__;
    return $global_responses->$name();
}

/**
* レスポンステータの格納
*
* @param mixed $response
* @param mixed $key
* @return array
*/
function setResponse($response, $key=null)
{
    global $global_responses;
    $name = __FUNCTION__;
    return $global_responses->$name($response, $key);
}

/**
* レスポンステータの初期化
*
* @return void
*/
function resetResponse()
{
    global $global_responses;
    $name = __FUNCTION__;
    return $global_responses->$name();
}

/**==================================================================
* モーダル関係の処理
==================================================================**/
/**
* モーダルテータの取得
*
* @return array
*/
function getModals()
{
    global $global_responses;
    $name = __FUNCTION__;
    return $global_responses->$name();
}

/**
* モーダル用テータの格納
*
* @param array $param
* @param boolean $merge
* @return array
*/
function setModal(array $param, bool $merge=false)
{
    global $global_responses;
    $name = __FUNCTION__;
    return $global_responses->$name($param, $merge);
}

/**
* モーダル情報の初期化
*
* @return void
*/
function resetModal()
{
    global $global_responses;
    $name = __FUNCTION__;
    return $global_responses->$name();
}
