<?php
$root_path = __DIR__.'/../../..';
// 親クラス
require_once($root_path.'/App/Services/Service.php');
// トレイト
require_once($root_path.'/App/Traits/Service/Battle/ServiceBattleAttackTrait.php');
require_once($root_path.'/App/Traits/Service/Battle/ServiceBattleEnemyTurnTrait.php');
require_once($root_path.'/App/Traits/Service/Battle/ServiceBattleAttackAfterTrait.php');
require_once($root_path.'/App/Traits/Service/Battle/ServiceBattleCheckTrait.php');
require_once($root_path.'/App/Traits/Service/Battle/ServiceBattleEnemyAiTrait.php');
require_once($root_path.'/App/Traits/Service/Battle/ServiceBattleOrderGenelatorTrait.php');
require_once($root_path.'/App/Traits/Service/Battle/ServiceBattleExTrait.php');
require_once($root_path.'/App/Traits/Service/Battle/ServiceBattleCalTrait.php');
require_once($root_path.'/App/Traits/Service/Item/ServiceItemUseTrait.php');
require_once($root_path.'/App/Traits/Service/Item/ServiceItemCaptureTrait.php');

/**
* どうぐの使用
*/
class ItemService extends Service
{
    // バトルで使用するトレイト
    use ServiceBattleAttackTrait;
    use ServiceBattleEnemyTurnTrait;
    use ServiceBattleAttackAfterTrait;
    use ServiceBattleCheckTrait;
    use ServiceBattleEnemyAiTrait;
    use ServiceBattleOrderGenelatorTrait;
    use ServiceBattleExTrait;
    use ServiceBattleCalTrait;
    // アイテムで使用するトレイト
    use ServiceItemUseTrait;
    use ServiceItemCaptureTrait;

    /**
    * 使用されたアイテム
    * @var object::Item
    */
    protected $item;

    /**
    * 捕獲フラグ
    * @var boolean
    */
    protected $capture_flg = false;

    /**
    * @return void
    */
    public function __construct()
    {
        //
    }

    /**
    * @return void
    */
    public function execute()
    {
        // アイテムの確認
        if(!$this->validation()){
            setMessage('指定されたアイテムは使用できません');
            return;
        }
        // アイテムの使用
        $this->use();
        if($this->capture_flg){
            // 捕獲成功
            // バトル終了判定用メッセージの格納
            setEmptyMessage('battle-end');
        }else{
            // 捕獲失敗
            //相手のターン処理
            $this->enemyTurn();
        }
    }

    /**
    * アイテムの検証
    * @return boolean
    */
    private function validation(): bool
    {
        // アイテム一覧を取得
        $items = player()->getItems();
        if(!isset($items[request('order')])){
            return false;
        }
        // 個数チェック(念の為)
        if($items[request('order')]['count'] <= 0){
            return false;
        }
        // どうぐをインスタンス化(プロパティへ格納)
        $this->item = new $items[request('order')]['class'];
        // 指定されたアイテムがポケモン対象の場合は、ポケモン番号をチェック
        if(
            $this->item->getTarget() === 'friend' &&
            is_null(player()->getPartner(request('pokemon')))
        ){
            return false;
        }
        // バリデーション通過
        return true;
    }

    /**
    * 使う
    * @return void
    */
    private function use(): void
    {
        setMessage(player()->getName().'は、'.$this->item->getName().'を使った');
        // アイテムの対象による分岐
        switch ($this->item->getTarget()) {
            // 味方ポケモン
            case 'friend':
            $result = $this->useItemToFriend($this->item);
            break;
            // 相手ポケモン
            case 'enemy':
            if($this->item->getCategory() === 'ball'){
                // 捕獲処理
                $result = $this->useItemCapture($this->item);
                // 捕獲フラグ
                $this->capture_flg = $result;
            }else{
                $result = $this->useItemToEnemy($this->item);
            }
            break;
        }
        // アイテムを1つ消費
        if($result){
            player()->subItem(request('order'));
        }
    }

}
