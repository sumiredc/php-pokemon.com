<?php
// トレイト
require_once app_path('Traits/Class/Pokebox/ClassPokeboxBoxTrait.php');
require_once app_path('Traits/Class/Pokebox/ClassPokeboxPokemonTrait.php');

// ポケモンボックス
class Pokebox
{
    use ClassPokeboxBoxTrait, ClassPokeboxPokemonTrait;

    /**
    * ポケモンの格納ボックス
    * @var array
    */
    protected $pokebox = [];

    /**
    * 選択中のボックス番号
    * @var integer
    */
    protected $selected = 0;

    /**
    * @return void
    */
    public function __construct()
    {
        // 初期ボックスを用意
         $this->addBox();
    }

    /**
    * 全ボックスの取得（暗号化状態で返却）
    * @return array
    */
    public function getPokebox(): array
    {
        return $this->pokebox;
    }

}
