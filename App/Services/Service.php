<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/App/Traits/ResponseTrait.php');

abstract class Service
{
    use ResponseTrait;

    /**
    * インスタンス作成時に実行される処理
    *
    * @return void
    */
    public function __construct()
    {
        //
    }

}
