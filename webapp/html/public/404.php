<?php
/**
* ページが見つかりませんでしあt(404)
*/
http_response_code(404);
// コアの読み込みではパス関数使用不可
require_once __DIR__.'/../core.php';
