<?php
/**
* バトル状態クラス
*/
class BattleState
{
    /**
    * 逃走を試みた回数
    * @var integer
    */
    private $run;

    /**
    * フィールド効果
    * @var integer
    */
    private $fields;

    /**
    * このターンに受けた攻撃によるダメージ量
    * @var array
    */
    private $turn_damages;

    /**
    * 最後に使用した技
    * @var array
    */
    private $last_moves;

    /**
    * @return void
    */
    public function __construct()
    {
        $this->init();
    }

    /**==================================================================
    * 初期化・初期値
    ==================================================================**/

    /**
    * 初期化
    * @return void
    */
    public function init() :void
    {
        $this->run = 0;
        $this->dafaultFields();
        $this->dafaultTurnDamages();
        $this->dafaultLastMoves();
    }

    /**
    * ターン始めの状態へ初期化
    * @return void
    */
    public function turnInit() :void
    {
        $this->dafaultTurnDamages();
    }

    /**
    * ターンダメージの初期値
    * @return void
    */
    public function dafaultTurnDamages() :void
    {
        $this->turn_damages = [
            'friend' => [
                'physical' => 0,
                'special' => 0,
            ],
            'enemy' => [
                'physical' => 0,
                'special' => 0,
            ],
        ];
    }

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
    * 最後に使用した技の初期値
    * @return void
    */
    public function dafaultLastMoves() :void
    {
        $this->last_moves = [
            'friend' => '',
            'enemy' => '',
            'all' => '',
        ];
    }

    /**==================================================================
    * にげる
    ==================================================================**/

    /**
    * にげる実行
    * @return void
    */
    public function run() :void
    {
        $this->run++;
    }

    /**
    * にげるの回数取得
    * @return integer
    */
    public function getRun() :int
    {
        return $this->run;
    }

    /**==================================================================
    * フィールド
    ==================================================================**/

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
    * ターンダメージの取得
    * @param position:string::friend|enemy
    * @return array
    */
    public function getField(string $position) :array
    {
        return $this->fields[$position];
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
            $this->fields[$target][get_class($field)] = $turn;
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

    /**==================================================================
    * ターンダメージ
    ==================================================================**/

    /**
    * ターンダメージの取得
    * @param position:string::friend|enemy
    * @param species:string::physical|special
    * @return integer
    */
    public function getTurnDamage(string $position, string $species) :int
    {
        return $this->turn_damages[$position][$species];
    }

    /**
    * このターン受けたダメージの格納
    * @param position:string::friend|enemy
    * @param species:string::physical|special
    * @param damage:integer
    * @return void
    */
    public function setTurnDamage(string $position, string $species, int $damage) :void
    {
        $this->turn_damages[$position][$species] = $damage;
    }

    /**==================================================================
    * 最後に使用した技
    ==================================================================**/

    /**
    * 最後に使用した技(クラス)の取得
    * @param position:string::friend|enemy|all
    * @return string
    */
    public function getLastMove(string $position = 'all')
    {
        return $this->last_moves[$position];
    }

    /**
    * 最後に使用した技(クラス)の格納
    * @param move:object|string::Move
    * @param position:string::friend|enemy
    * @return void
    */
    public function setLastMove(string $position, $move)
    {
        // オブジェクト・文字列（クラス名）両方を許可
        if(is_object($move)){
            $class = get_class($move);
        }else{
            $class = $move;
        }
        $this->last_moves[$position] = $class;
        $this->last_moves['all'] = $class;
    }

}
