<?php
/**
* ポケモン
*/
class PokemonTransform
{

    /**
    * ポケモン
    * @var string
    */
    public $pokemon;

    /**
    * 覚えている技
    * @var array
    */
    public $move = [];

    /**
    * 種族値
    * @var array
    */
    public $base_stats = [];

    /**
    * 個体値
    * @var array::value:min:0|max:31
    */
    public $iv = [];

    /**
    * 努力値
    * @var array
    */
    public $ev = [];

    /**
    * ランク（バトルステータス）
    * @var array::value:min:-6|max:6
    */
    public $rank = [];

}
