<?php
/**
* どうぐ
*/
abstract class Item
{

    /**
    * 性能値（捕獲補正率※ボールのみ個別で設定）
    * @var float
    */
    public const PERFORMANCE = 0;

    /**
    * 現在のページで使用できるかどうかの判定
    * @param page:string
    * @return boolean
    */
    public static function allowUsed($page): bool
    {
        return in_array($page, static::TIMING, true);
    }

    /**
    * 削除できるかどうかの判定
    * @return boolean
    */
    public static function allowTrashed(): bool
    {
        // 最大所有数が設定されていれば削除可
        if(is_null(static::MAX)){
            return false;
        }
        return true;
    }

}
