<?php
$root_path = __DIR__.'/..';
// トレイト
require_once($root_path.'/App/Traits/Class/Player/ClassPlayerItemTrait.php');
require_once($root_path.'/App/Traits/Class/Player/ClassPlayerBadgeTrait.php');
require_once($root_path.'/App/Traits/Class/Player/ClassPlayerMoneyTrait.php');
/**
* プレイヤー情報
*/
class Player
{
    use ClassPlayerItemTrait;
    use ClassPlayerBadgeTrait;
    use ClassPlayerMoneyTrait;

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
    * 持ち物
    * [[class => string, count => int|null], ...]
    * @var array
    */
    protected $items = [];

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

}
