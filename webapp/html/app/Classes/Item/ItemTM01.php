<?php
require_once app_path('Classes/Item.php');

/**
* わざマシン01
*/
class ItemTM01 extends Item
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'わざマシン01';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '';

    /**
    * カテゴリ
    * @var string::general|health|ball|important|machine
    */
    public const CATEGORY = 'machine';

    /**
    * 技(わざマシンのみ)
    * @var string
    */
    public const MOVE = 'MoveMegaPunch';

    /**
    * 最大所有数
    * @var integer
    */
    public const MAX = 1;

    /**
    * 買値
    * @var integer
    */
    public const BID_PRICE = 3000;

    /**
    * 売値
    * @var integer
    */
    public const SELL_PRICE = 1500;

    /**
    * 対象
    * @var string::friend|enemy|player|friend_battle
    */
    public const TARGET = 'friend';

    /**
    * 使用できるタイミング
    * @var array
    */
    public const TIMING = ['home'];

    /**
    * 使用できるポケモン
    * @var string
    */
    public const POKEMON = 'tm.MoveMegaPunch';

    /**
    * アイテム効果
    * @return object:Pokemon
    */
    public static function effects(Pokemon $pokemon)
    {
        // 使用不可
        if(!in_array(get_class($pokemon), static::getUsePokemon(), true)){
            return [
                'message' => $pokemon->getNickname().'は、'.static::NAME.'との相性が悪かった',
                'result' => false,
            ];
        }
        // 技を覚えさせる
        return [
            'result' => $pokemon->isLearnMachineMove(get_class()),
        ];
    }

}
