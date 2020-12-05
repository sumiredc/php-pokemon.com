<?php
$root_path = __DIR__.'/..';
// トレイト
require_once($root_path.'/Classes/Pokedex.php');
require_once($root_path.'/App/Traits/Class/Player/ClassPlayerItemTrait.php');
require_once($root_path.'/App/Traits/Class/Player/ClassPlayerBadgeTrait.php');
require_once($root_path.'/App/Traits/Class/Player/ClassPlayerMoneyTrait.php');
require_once($root_path.'/App/Traits/Class/Player/ClassPlayerPartyTrait.php');
/**
* プレイヤー情報
*/
class Player
{
    use ClassPlayerItemTrait;
    use ClassPlayerBadgeTrait;
    use ClassPlayerMoneyTrait;
    use ClassPlayerPartyTrait;

    /**
    * 名前
    * @var string
    */
    protected $name = '';

    /**
    * プレイヤーレベル
    * @var integer
    */
    protected $level = 1;

    /**
    * おこづかい
    * @var integer
    */
    protected $money = 2000;

    /**
    * パーティー
    * @var array
    */
    protected $party = [];

    /**
    * ポケモン図鑑
    * @var object::Pokedex
    */
    protected $pokedex;

    /**
    * ジムバッジ
    * @var array
    */
    protected $badges;

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
        $this->pokedex = new Pokedex;
        $this->setDefaultBadges();
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

    /**
    * プレイヤーレベルの取得
    * @return integer
    */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
    * プレイヤーレベルを1上昇させる
    * @return void
    */
    public function levelUp(): void
    {
        $this->level++;
    }

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
    * 図鑑の取得
    * @return object::Pokedex
    */
    public function pokedex(): object
    {
        return $this->pokedex;
    }

}
