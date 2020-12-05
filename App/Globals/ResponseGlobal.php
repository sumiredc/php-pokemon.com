<?php
// レスポンス用グローバル関数
$root_path = __DIR__.'/../..';
// クラス読み込み
require_once($root_path.'/Classes/Response.php');
$global_response = new Response;

/**
* レスポンスクラスの取得
* @return object::Response
*/
function response()
{
    global $global_response;
    return $global_response;
}

// /**
// * メッセージIDの発行
// * @return string
// */
// function issueMsgId()
// {
//     global $global_response;
//     $name = __FUNCTION__;
//     return $global_response->$name();
// }

// /**
// * 使用中のメッセージIDを格納
// * @return string
// */
// function setUsedMessageId($arg)
// {
//     global $global_response;
//     $name = __FUNCTION__;
//     return $global_response->$name($arg);
// }
//
// /**
// * 全リセット
// * @return void
// */
// function resetResponsesAll()
// {
//     global $global_response;
//     $name = __FUNCTION__;
//     $global_response->$name();
// }

/**==================================================================
* メッセージ関係の処理
==================================================================**/
// /**
// * メッセージの取得
// * @return array
// */
// function getMessages()
// {
//     global $global_response;
//     $name = __FUNCTION__;
//     return $global_response->$name();
// }

// /**
// * メッセージの格納
// * @param string|array $msg
// * @param mixed $param
// * @return void
// */
// function setMessage($msg, $param=null)
// {
//     global $global_response;
//     $name = __FUNCTION__;
//     $global_response->$name($msg, $param);
// }
//
// /**
// * アニメーション用の自動メッセージの格納
// * @param mixed $param
// * @return void
// */
// function setAutoMessage($param)
// {
//     global $global_response;
//     $name = __FUNCTION__;
//     $global_response->$name($param);
// }
//
// /**
// * 空メッセージの格納
// * @param string $param
// * @return void
// */
// function setEmptyMessage(string $param='')
// {
//     global $global_response;
//     $name = __FUNCTION__;
//     $global_response->$name($param);
// }
//
// /**
// * メッセージの初期化
// * @return void
// */
// function resetMessage()
// {
//     global $global_response;
//     $name = __FUNCTION__;
//     $global_response->$name();
// }
//
// /**
// * メッセージの最初のキーを取得
// * @return mixed
// */
// function getMessageFirstKey()
// {
//     global $global_response;
//     $name = __FUNCTION__;
//     return $global_response->$name();
// }
//
// /**
// * メッセージの最後のキーを取得
// * @return mixed
// */
// function getMessageLastKey()
// {
//     global $global_response;
//     $name = __FUNCTION__;
//     return $global_response->$name();
// }

/**==================================================================
* レスポンス関係の処理
==================================================================**/
// /**
// * 指定したレスポンステータの取得
// * @param string|integer
// * @return mixed
// */
// function getResponse($param)
// {
//     global $global_response;
//     $name = __FUNCTION__;
//     return $global_response->$name($param);
// }
//
// /**
// * レスポンステータの全取得
// * @return array
// */
// function getResponses()
// {
//     global $global_response;
//     $name = __FUNCTION__;
//     return $global_response->$name();
// }
//
// /**
// * レスポンステータの格納
// * @param mixed $response
// * @param mixed $key
// * @return array
// */
// function setResponse($response, $key=null)
// {
//     global $global_response;
//     $name = __FUNCTION__;
//     return $global_response->$name($response, $key);
// }
//
// /**
// * レスポンステータの初期化
// * @return void
// */
// function resetResponse()
// {
//     global $global_response;
//     $name = __FUNCTION__;
//     return $global_response->$name();
// }

/**==================================================================
* モーダル関係の処理
==================================================================**/
// /**
// * モーダルテータの取得
// * @return array
// */
// function getModals()
// {
//     global $global_response;
//     $name = __FUNCTION__;
//     return $global_response->$name();
// }
//
// /**
// * モーダル用テータの格納
// * @param array $param
// * @param boolean $merge
// * @return array
// */
// function setModal(array $param, bool $merge=false)
// {
//     global $global_response;
//     $name = __FUNCTION__;
//     return $global_response->$name($param, $merge);
// }
//
// /**
// * モーダル情報の初期化
// * @return void
// */
// function resetModal()
// {
//     global $global_response;
//     $name = __FUNCTION__;
//     return $global_response->$name();
// }
//
//
// /**
// * 強制表示モーダルの初期化
// * @return void
// */
// function initForceModal()
// {
//     global $global_response;
//     $name = __FUNCTION__;
//     return $global_response->$name();
// }
//
// /**
// * 強制表示モーダルのセット
// * @param id:string
// * @return boolean
// */
// function setForceModal($id)
// {
//     global $global_response;
//     $name = __FUNCTION__;
//     return $global_response->$name($id);
// }
//
// /**
// * 強制表示モーダルを待機状態にする（更新等された際に強制表示）
// * @param id:string
// * @return void
// */
// function waitForceModal($id)
// {
//     global $global_response;
//     $name = __FUNCTION__;
//     return $global_response->$name($id);
// }
//
// /**
// * 強制表示モーダルを待機状態にする（更新等された際に強制表示）
// * @param id:string
// * @return boolean
// */
// function setWaitForceModal()
// {
//     global $global_response;
//     $name = __FUNCTION__;
//     return $global_response->$name();
// }
//
// /**
// * 強制表示モーダルの存在確認
// * @return boolean
// */
// function isForceModal()
// {
//     global $global_response;
//     $name = __FUNCTION__;
//     return $global_response->$name();
// }
//
// /**
// * 強制表示モーダルの取得
// * @return array
// */
// function getForceModal()
// {
//     global $global_response;
//     $name = __FUNCTION__;
//     return $global_response->$name();
// }
//
// /**
// * 強制モーダルの確認
// * @return boolean
// */
// function isForceModalTarget($target)
// {
//     global $global_response;
//     $name = __FUNCTION__;
//     return $global_response->$name($target);
// }
