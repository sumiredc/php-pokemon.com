<?php
/**==================================================================
* フィールド
==================================================================**/
trait ClassBattleStateFieldTrait
{

    /**
    * フィールドの初期値
    * @return void
    */
    public function dafaultFields(): void
    {
        $this->fields = [
            'friend' => [],
            'enemy' => [],
        ];
    }

    /**
    * フィールド状態の確認
    * @param position:string::friend|enemy
    * @param field:string
    * @return boolean
    */
    public function checkField(string $position, string $field): bool
    {
        if(isset($this->fields[$position][$field])){
            return true;
        }else{
            return false;
        }
    }

    /**
    * フィールド情報の取得
    * @param position:string::friend|enemy
    * @return array
    */
    public function getFields(string $position): array
    {
        // そのまま返却
        return $this->fields[$position];
    }

    /**
    * フィールドのセット
    * @param position:string::friend|enemy
    * @param field:string
    * @param turn:integer
    * @return void
    */
    public function setField(string $position, string $field, int $turn): void
    {
        if($this->checkField($position, $field)){
            // 既にセットされている
            response()->setMessage($field::getAlreadyMessage($position));
        }else{
            // フィールドをセット
            $this->fields[$position][$field] = $turn;
            response()->setMessage($field::getSetMessage($position));
        }
    }

    /**
    * フィールド状態の解除
    * @param position:string
    * @param field:string
    * @return void
    */
    public function releaseField(string $position, string $field): void
    {
        if($this->checkField($position, $field)){
            // 解除
            unset($this->fields[$position][$field]);
            // 解除メッセージをセット
            response()->setMessage($field::getReleaseMessage($position));
        }
    }

    /**
    * フィールドのターンカウントを進める
    * @return void
    */
    public function goTurnFields(): void
    {
        foreach(['friend', 'enemy'] as $position){
            //全ターゲットのフィールド状態を解除
            foreach($this->fields[$position] as $field => &$turn){
                $turn--;
                if($turn <= 0){
                    // 残ターンが０ターン以下になれば解除
                    $this->releaseField($position, $field);
                }
            }
        } # endforeach
    }

}
