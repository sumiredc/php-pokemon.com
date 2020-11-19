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
    public function dafaultFields() :void
    {
        $this->fields = [
            'friend' => [],
            'enemy' => [],
        ];
    }

    /**
    * フィールド状態の確認
    * @param position:string::friend|enemy
    * @param field:object::Field
    * @return boolean
    */
    public function checkField(string $position, object $field) :bool
    {
        if(isset($this->fields[$position][get_class($field)])){
            return true;
        }else{
            return false;
        }
    }

    /**
    * フィールド情報の取得
    * @param position:string::friend|enemy
    * @param object_flg:boolean
    * @return array
    */
    public function getField(string $position, bool $object_flg=false) :array
    {
        if($object_flg){
            // フィールドをオブジェクトにして返却
            $fields = [];
            foreach($this->fields[$position] as $class => $turn){
                $fields[] = [new $class, $turn];
            }
            return $fields;
        }else{
            // そのまま返却
            return $this->fields[$position];
        }
    }

    /**
    * フィールドのセット
    * @param position:string::friend|enemy
    * @param field:object::Field
    * @param turn:integer
    * @return void
    */
    public function setField(string $position, object $field, int $turn) :void
    {
        if($this->checkField($position, $field)){
            // 既にセットされている
            setMessage($field->getAlreadyMessage($position));
        }else{
            // フィールドをセット
            $this->fields[$position][get_class($field)] = $turn;
            setMessage($field->getSetMessage($position));
        }
    }

    /**
    * フィールド状態の解除
    * @param position:string
    * @param field:object::Field
    * @return void
    */
    public function releaseField(string $position, object $field) :void
    {
        if($this->checkField($position, $field)){
            // 解除
            unset($this->fields[$position][get_class($field)]);
            // 解除メッセージをセット
            setMessage($field->getReleaseMessage($position));
        }
    }

    /**
    * フィールドのターンカウントをすすめる
    * @return void
    */
    public function goTurnFields() :void
    {
        foreach(['friend', 'enemy'] as $position){
            //全ターゲットのフィールド状態を解除
            foreach($this->fields[$position] as $field => &$turn){
                $turn--;
                if($turn <= 0){
                    // 残ターンが０ターン以下になれば解除
                    $this->releaseField($position, new $field);
                }
            }
        }
    }

}
