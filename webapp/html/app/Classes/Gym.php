<?php
/**
 * ジム
 */
abstract class Gym
{

    /**
    * ジムリーダー情報を取得
    * @return array
    */
    public static function getLeaderInfo(): array
    {
        // 配列を返却
        return include(
            storage_path('database/leaders').static::LEADER.'.php'
        );
    }

    /**
    * ジムリーダーのbase64画像を取得
    * @param pause:string
    * @return string:base64
    */
    public static function base64Leader($pause='front'): string
    {
        // 拡張子の分岐
        if($pause === 'front'){
            $ex = '.gif';
        }else{
            $ex = '.png';
        }
        // base64形式で返却
        return base64_storage('leaders/'.static::LEADER.'/'.$pause.$ex);
    }

    /**
    * バッジのbase64画像を取得
    * @return string:base64
    */
    public static function base64Badge(): string
    {
        // base64形式で返却
        return base64_storage('badges/'.static::BADGE.'.png');
    }

}
