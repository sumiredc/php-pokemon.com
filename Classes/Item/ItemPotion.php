<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Item.php');

// キズぐすり
class ItemPotion extends Item
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'キズぐすり';

    /**
    * 説明文
    * @var string
    */
    protected $description = 'スプレー式のキズぐすり。ポケモン1匹のHPを20だけ回復する。';

    /**
    * カテゴリ
    * @var string::general|health|ball|important|machine
    */
    protected $category = 'health';

    /**
    * 最大所有数
    * @var integer
    */
    protected $max = 99;

    /**
    * 買値
    * @var integer
    */
    protected $bid_price = 200;

    /**
    * 売値
    * @var integer
    */
    protected $sell_price = 100;

    /**
    * 対象
    * @var string::friend|enemy|player
    */
    protected $target = 'friend';

    /**
    * 使用できるタイミング
    * @var array
    */
    protected $timing = ['battle', 'home'];

    /**
    * 効果
    * @return array
    */
    public function effects($pokemon)
    {
        $before = $pokemon->getRemainingHp();
        if($before < $pokemon->getStats('HP')){
            // HP20回復
            $after = $pokemon->calRemainingHp('add', 20);
            $message = $pokemon->getPrefixName().'のHPが'.($after - $before).'回復した';
            $result = true;
        }else{
            // 効果なし
            $message = '使っても効果がないよ';
            $result = false;
        }
        // メッセージを返却
        return [
            'message' => $message,
            'result' => $result
        ];
    }

}
