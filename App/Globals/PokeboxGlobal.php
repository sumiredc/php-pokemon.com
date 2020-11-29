<?php
$global_pokebox = $_SESSION['__pokebox'] ?? null;
// クラス読み込み
require_once($root_path.'/Classes/Pokebox.php');

/**
* ボックスの取得
* @return object::Pokebox
*/
function pokebox()
{
    global $global_pokebox;
    return $global_pokebox;
}

/**
* ボックスの初期化
* @return void
*/
function initPokebox()
{
    global $global_pokebox;
    $_SESSION['__pokebox'] = serializeObject(new Pokebox);
    $global_pokebox = $_SESSION['__pokebox'];
}

/**
* ボックスの起動
* @return void
*/
function startPokebox()
{
    global $global_pokebox;
    if($global_pokebox){
        // 復号化
        $global_pokebox = unserializeObject($global_pokebox);
    }else{
        // 初期化されていなければ新規作成
        $global_pokebox = new Pokebox;
    }
}

/**
* ボックスの終了
* @return void
*/
function shutdownPokebox()
{
    global $global_pokebox;
    // 暗号化して格納
    $_SESSION['__pokebox'] = serializeObject($global_pokebox);
    $global_pokebox = $_SESSION['__pokebox'];
}

/**
* ボックスの保存
* @return void
*/
function savePokebox()
{
    global $global_pokebox;
    // 暗号化して格納
    $_SESSION['__pokebox'] = serializeObject($global_pokebox);
}
