<?php
require_once(root_path('Classes').'Item.php');

/**
* かみなりのいし
*/
class ItemThunderStone extends Item
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'かみなりのいし';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = 'ある 特定の ポケモンを 進化させる 不思議な 石。稲妻の 模様が ある。';

    /**
    * カテゴリ
    * @var string::general|health|ball|important|machine
    */
    public const CATEGORY = 'general';

    /**
    * 最大所有数
    * @var integer
    */
    public const MAX = 99;

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
    * @var array
    */
    public const POKEMON = [
        'Pikachu', 'Eievui'
    ];

    /**
    * アイテム効果
    * @return array
    */
    public static function effects($pokemon)
    {
        // 効果なし
        if(!in_array(get_class($pokemon), static::POKEMON, true)){
            return [
                'message' => '使っても効果がないよ',
                'result' => false,
            ];
        }
        // 進化判定の結果を返却
        return [
            'result' => $pokemon->judgeEvolve(get_class()),
            'action' => 'evolve',
        ];
    }

}
