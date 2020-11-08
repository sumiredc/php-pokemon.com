<?php

// フィールド状態
abstract class Field
{

    // プロパティの初期値
    protected $set_msg = '';
    protected $already_msg = '';
    protected $release_msg = '';
    protected $failed_msg = '';

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
    * 名称の取得
    *
    * @return string
    */
    public function getName()
    {
        return $this->name;
    }

    /**
    * フィールドセット時のメッセージ
    *
    * @param string $target
    * @return string
    */
    public function getSetMessage($target)
    {
        $prefix = '味方';
        if($target === 'enemy'){
            $prefix = '相手';
        }
        return str_replace('::prefix', $prefix, $this->set_msg);
    }

    /**
    * 既にフィールドがセットされている時のメッセージ
    *
    * @param string $target
    * @return string
    */
    public function getAlreadyMessage($target)
    {
        $prefix = '味方';
        if($target === 'enemy'){
            $prefix = '相手';
        }
        return str_replace('::prefix', $prefix, $this->already_msg);
    }

    /**
    * フィールド解除時のメッセージ
    *
    * @param string $target
    * @return string
    */
    public function getReleaseMessage($target)
    {
        $prefix = '味方';
        if($target === 'enemy'){
            $prefix = '相手';
        }
        return str_replace('::prefix', $prefix, $this->release_msg);
    }

    /**
    * 状態異常にかかった際のメッセージを取得
    *
    * @param string $pokemon
    * @return string
    */
    public function getFailedMessage($pokemon)
    {
        return str_replace('::pokemon', $pokemon, $this->failed_msg);
    }

}
