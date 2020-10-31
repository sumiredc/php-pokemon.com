<?php
// フォーム用グローバル関数
$root_path = __DIR__.'/../..';
/**
* トークン出力用関数
* @return void
*/
function input_token()
{
    echo '<input type="hidden" name="__token" value="'.$_SESSION['__token'].'">';
}
