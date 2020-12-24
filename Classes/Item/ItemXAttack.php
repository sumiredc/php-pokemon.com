<?php
require_once(root_path('Classes').'Item.php');

/**
* プラスパワー
*/
class ItemXAttack extends Item
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'プラスパワー';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '戦闘中の ポケモンの 攻撃を 大きく あげる 道具。ひっこめると 元に 戻る。';

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
    public const BID_PRICE = 1000;

    /**
    * 売値
    * @var integer
    */
    public const SELL_PRICE = 500;

    /**
    * 対象
    * @var string::friend|enemy|player|friend_battle
    */
    public const TARGET = 'friend_battle';

    /**
    * 使用できるタイミング
    * @var array
    */
    public const TIMING = ['battle'];

    /**
    * 効果
    * @return array
    */
    public static function effects($pokemon)
    {
        // 効果なし
        if(
            $pokemon->getRank('A') >= 6 ||
            $pokemon->isFainting()
        ){
            return [
                'message' => '使っても効果がないよ',
                'result' => false,
            ];
        }
        // メッセージを返却
        return [
            'message' => $pokemon->addRank('A', 2), # こうげきランクを２段階上昇
            'result' => true,
        ];
    }

}
