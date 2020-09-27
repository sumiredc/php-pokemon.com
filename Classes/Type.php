<?php

// タイプ
abstract class Type
{

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
    * タイプ名の取得
    *
    * @return string
    */
    public function getName()
    {
        return $this->name;
    }

    /**
    * 攻撃で有利なタイプ
    *
    * @return array
    */
    public function getAtkExcellentTypes()
    {
        return $this->excellent;
    }

    /**
    * 攻撃で相性が悪いタイプの取得
    *
    * @return array
    */
    public function getAtkNotVeryTypes()
    {
        return $this->not_very;
    }

    /**
    * 攻撃で全く効果が無いタイプの取得
    *
    * @return array
    */
    public function getAtkDoesntAffectTypes()
    {
        return $this->doesnt_affect;
    }

}
