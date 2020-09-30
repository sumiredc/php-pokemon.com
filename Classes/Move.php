<?php
require_once(__DIR__.'/../Traits/InstanceTrait.php');
require_once(__DIR__.'/../Traits/ResponseTrait.php');

// 技
abstract class Move
{
    use InstanceTrait;
    use ResponseTrait;

    /**
    * チャージ技
    * @var boolean
    */
    protected $charge = false;

    /**
    * インスタンス作成時に実行される処理
    *
    * @return void
    */
    public function __construct()
    {
        //
    }

    /**
    * チャージ効果
    *
    * @return void
    */
    public function charge($atk)
    {
        // チャージ不要
        return false;
    }

    /**
    * 追加効果
    *
    * @return void
    */
    public function effects(...$args)
    {
        //
    }

    /**
    * 名称の取得
    *
    * @return string
    */
    public function getName()
    {
        return $this->name;
    }

    /**
    * 説明文の取得
    *
    * @return string
    */
    public function getDescription()
    {
        return $this->description;
    }

    /**
    * タイプの取得
    *
    * @return object
    */
    public function getType()
    {
        return $this->getInstance($this->type);
    }

    /**
    * 分類の取得
    *
    * @return string
    */
    public function getSpecies()
    {
        return $this->species;
    }

    /**
    * 威力の取得
    *
    * @return string
    */
    public function getPower()
    {
        return $this->power;
    }

    /**
    * 命中率の取得
    *
    * @return integer
    */
    public function getAccuracy()
    {
        return $this->accuracy;
    }

    /**
    * 使用回数の取得
    *
    * @return integer
    */
    public function getPp()
    {
        return $this->pp;
    }

    /**
    * 優先度の取得
    *
    * @return integer
    */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
    * 急所ランクの取得
    *
    * @return integer
    */
    public function getCritical()
    {
        return $this->critical ?? 0;
    }

}
