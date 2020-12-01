<?php
/**
* ページが見つかりませんでしあt(404)
*/
http_response_code(404);
$root_path = __DIR__.'/..';
require_once($root_path.'/core.php');
