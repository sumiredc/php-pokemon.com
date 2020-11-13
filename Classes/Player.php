<?php
/**
* プレイヤー情報
*/
class Player
{

    /**
    * 名前
    * @var string
    */
    protected $name = '';

    /**
    * おこづかい
    * @var integer
    */
    protected $money = 2000;

    /**
    * ジムバッジ
    * @var integer
    */
    protected $badges = [
        'Boulder' => false,  # グレーバッジ
        'Cascade' => false,  # ブルーバッジ
        'Thunder' => false,  # オレンジバッジ
        'Rainbow' => false,  # レインボーバッジ
        'Soul' => false,     # ピンクバッジ
        'Marsh' => false,    # ゴールドバッジ
        'Volcano' => false,  # クリムゾンバッジ
        'Earth' => false,    # グリーンバッジ
    ];

    /**
    * @param name:string
    * @return void
    */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**==================================================================
    * 名前
    ==================================================================**/
    /**
    * 名前の取得
    * @return string
    */
    public function getName(): string
    {
        return $this->name;
    }

    /**==================================================================
    * おこづかい
    ==================================================================**/
    /**
    * おこづかいの増加
    * @param money:integer
    * @return void
    */
    public function addMoney($money): void
    {
        $this->money += $money;
    }

    /**
    * おこづかいの消費
    * @param money:integer
    * @return void
    */
    public function subMoney($money): void
    {
        $this->money -= $money;
    }

    /**
    * おこづかいの取得
    * @return integer
    */
    public function getMoney() :int
    {
        return $this->money;
    }

    /**==================================================================
    * ジムバッジ
    ==================================================================**/

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
