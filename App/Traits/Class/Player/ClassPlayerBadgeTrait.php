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
    protected $badges = [];

    /**
    * バッジを初期状態にする
    * @return void
    */
    private function setDefaultBadges(): void
    {
        // configから取得したジム情報を使ってバッチリストを作成
        foreach(config('gym') as $gym){
            $this->badges[$gym::BADGE] = false;
        }
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
