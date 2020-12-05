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
require_once($root_path.'/App/Traits/Service/Common/ServiceCommonRegistPokedexTrait.php');

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
    // 図鑑登録
    use ServiceCommonRegistPokedexTrait;

    /**
    * 捕獲フラグ
    * @var boolean
    */
    protected $capture_flg = false;

    /**
    * アイテム使用時のメッセージID
    * @var string
    */
    protected $use_msg_id;

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
            response()->setMessage('指定されたアイテムは使用できません');
            return;
        }
        // アイテムの使用
        $this->use();
        if($this->capture_flg){
            // 捕獲成功
            // バトル終了判定用メッセージの格納
            response()->setEmptyMessage('battle-end');
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
        if(!player()->isItem(request('order'))){
            return false;
        }
        // 個数チェック(念の為)
        if(player()->getItemCount(request('order')) <= 0){
            return false;
        }
        // どうぐをプロパティへ格納
        $item = player()->getItemClass(request('order'));
        // 指定されたアイテムがポケモン対象の場合は、ポケモン番号をチェック
        if(
            $item::TARGET === 'friend' &&
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
        // 使用時のメッセージIDを発行
        $this->use_msg_id = response()->issueMsgId();
        $item = player()->getItemClass(request('order'));
        response()->setMessage(
            player()->getName().'は、'.$item::NAME.'を使った',
            $this->use_msg_id
        );
        // アイテムの対象による分岐
        switch ($item::TARGET) {
            // 味方ポケモン
            case 'friend':
            $result = $this->useItemToFriend($item);
            break;
            // 相手ポケモン
            case 'enemy':
            if($item::CATEGORY === 'ball'){
                // 捕獲処理
                $this->capture_flg = $this->useItemCapture($item);
                // アイテム処理正常終了判定
                $result = true;
            }else{
                $result = $this->useItemToEnemy($item);
            }
            break;
        }
        // アイテムを1つ消費
        if($result){
            player()->subItem(request('order'));
        }
    }

}
