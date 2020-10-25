<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/App/Traits/ResponseTrait.php');
require_once($root_path.'/App/Traits/SerializeTrait.php');

abstract class Service
{
    use ResponseTrait;
    use SerializeTrait;

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
