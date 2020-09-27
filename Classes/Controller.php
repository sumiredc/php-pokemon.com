<?php
require_once(__DIR__.'/AutoLoader.php');
require_once(__DIR__.'/../Traits/ResponseTrait.php');
require_once(__DIR__.'/../Traits/InstanceTrait.php');

// コントローラー
abstract class Controller
{
    use ResponseTrait;
    use InstanceTrait;

    /**
    * ポケモン格納用
    * @var object
    */
    protected $pokemon;

    /**
    * @return void
    */
    public function __construct()
    {
        // オートローダーの起動
        new AutoLoader();
    }

    /**
    * ポケモン情報の取得
    *
    * @return object
    */
    public function getPokemon()
    {
        return $this->pokemon;
    }

}
