<?php
// フィールド関係のトレイト
trait CommonFieldTrait
{

    /**
    * フィールド状態の確認
    *
    * @param string $target
    * @param Field:object $field
    * @return boolean
    */
    protected function checkField(string $target, object $field)
    {
        if(isset($this->field[$target][get_class($field)])){
            return true;
        }else{
            return false;
        }
    }

    /**
    * フィールド状態の取得
    *
    * @return boolean
    */
    public function getField()
    {
        return $this->field;
    }

    /**
    * フィールドのセット
    *
    * @param string $target
    * @param Field:object $field
    * @param integer $turn
    * @return void
    */
    protected function setField(string $target, object $field, int $turn)
    {
        if($this->checkField($target, $field)){
            // 既にセットされている
            $this->setMessage($field->getAlreadyMessage($target));
        }else{
            // フィールドをセット
            $this->field[$target][get_class($field)] = $turn;
            $this->setMessage($field->getSetMessage($target));
        }
    }

    /**
    * フィールド状態の解除
    *
    * @param string $target
    * @param Field:object $field
    * @return boolean
    */
    protected function releaseField(string $target, object $field)
    {
        if($this->checkField($target, $field)){
            // 解除
            unset($this->field[$target][get_class($field)]);
            // 解除メッセージをセット
            $this->setMessage($field->getReleaseMessage($target));
        }
    }

    /**
    * ターンカウントをすすめる（状態変化）
    *
    * @return void
    */
    protected function goFieldTurn()
    {
        $targets = ['friend', 'enemy'];
        foreach($targets as $target){
            // 全ターゲットのフィールド状態を解除
            foreach($this->field[$target] as $field => &$turn){
                $turn--;
                if($turn <= 0){
                    // 残ターンが０ターン以下になれば解除
                    $this->releaseField($target, new $field);
                }
            }
        }
    }

}
