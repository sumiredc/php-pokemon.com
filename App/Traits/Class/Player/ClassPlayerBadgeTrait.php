<?php
/**==================================================================
* ジムバッジ
==================================================================**/
trait ClassPlayerBadgeTrait
{

    /**
    * ジムバッジ
    * @var array
    */
    protected $badges;

    /**
    * バッジを初期状態にする
    * @return void
    */
    private function setDefaultBadges(): void
    {
        // configからバッジを取得
        $badges = array_map(function($gym){
            return $gym[1];
        }, config('gym'));
        // 値とキーを入れ替えて、全てにfalseをセット
        $this->badges = array_map(function($badge){
            return false;
        }, array_flip($badges));
    }

    /**
    * ジムバッジの確認
    * @param key:string
    * @return boolean
    */
    public function isBadge(string $key) :bool
    {
        return $this->badges[$key];
    }

    /**
    * ジムバッジの全取得
    * @return array
    */
    public function getBadges() :array
    {
        return $this->badges;
    }

    /**
    * ジムバッジの取得
    * @param key:string
    * @return void
    */
    public function setBadge(string $key) :void
    {
        $this->badges[$key] = true;
    }

}
