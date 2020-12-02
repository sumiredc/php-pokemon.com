<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Item.php');

/**
* キズぐすり
*/
class ItemPotion extends Item
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'キズぐすり';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = 'スプレー式のキズぐすり。ポケモン1匹のHPを20だけ回復する。';

    /**
    * カテゴリ
    * @var string::general|health|ball|important|machine
    */
    public const CATEGORY = 'health';

    /**
    * 最大所有数
    * @var integer
    */
    public const MAX = 99;

    /**
    * 買値
    * @var integer
    */
    public const BID_PRICE = 200;

    /**
    * 売値
    * @var integer
    */
    public const SELL_PRICE = 100;

    /**
    * 対象
    * @var string::friend|enemy|player
    */
    public const TARGET = 'friend';

    /**
    * 使用できるタイミング
    * @var array
    */
    public const TIMING = ['battle', 'home'];

    /**
    * 効果
    * @return array
    */
    public static function effects($pokemon)
    {
        $before = $pokemon->getRemainingHp();
        if($before < $pokemon->getStats('HP')){
            // HP20回復
            $after = $pokemon->calRemainingHp('add', 20);
            $heal = $after - $before;
            $message = $pokemon->getPrefixName().'のHPが'.$heal.'回復した';
            $result = true;
        }else{
            // 効果なし
            $message = '使っても効果がないよ';
            $result = false;
        }
        // メッセージを返却
        return [
            'message' => $message,
            'result' => $result,
            'hpbar' => $heal * -1, # 回復のためマイナス値をセット
        ];
    }

}
