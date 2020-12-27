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
        // configから取得したバッジ情報の値とキーを入れ替えて、全てにfalseをセット
        $this->badges = array_map(function($badge){
            return false;
        }, array_flip(config('gym')));
    }

    /**
    * ジムバッジの確認
    * @param key:string
    * @return boolean
    */
    public function isBadge(string $key): bool
    {
        return $this->badges[$key];
    }

    /**
    * ジムバッジの全取得
    * @return array
    */
    public function getBadges(): array
    {
        return $this->badges;
    }

    /**
    * ジムバッジの獲得
    * @param key:string
    * @return void
    */
    public function setBadge(string $key): void
    {
        $this->badges[$key] = true;
    }

    /**
    * ジムバッジの所有数を取得
    * @return int
    */
    public function getBadgeCount(): int
    {
        $badges = array_filter($this->badges, function($badge){
            return $badge;
        });
        return count($badges);
    }

}
