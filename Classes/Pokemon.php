<?php
$root_path = __DIR__.'/..';
// トレイト
require_once($root_path.'/App/Traits/Class/Pokemon/ClassPokemonSetTrait.php');
require_once($root_path.'/App/Traits/Class/Pokemon/ClassPokemonGetTrait.php');
require_once($root_path.'/App/Traits/Class/Pokemon/ClassPokemonDefaultTrait.php');
require_once($root_path.'/App/Traits/Class/Pokemon/ClassPokemonCheckTrait.php');
require_once($root_path.'/App/Traits/Class/Pokemon/ClassPokemonCalculationTrait.php');
require_once($root_path.'/App/Traits/Class/Pokemon/ClassPokemonReleaseTrait.php');
require_once($root_path.'/App/Traits/Class/Pokemon/ClassPokemonGoTurnTrait.php');
require_once($root_path.'/App/Traits/Class/Pokemon/ClassPokemonTransformTrait.php');

// ポケモン
abstract class Pokemon
{
    use ClassPokemonSetTrait;
    use ClassPokemonGetTrait;
    use ClassPokemonDefaultTrait;
    use ClassPokemonCheckTrait;
    use ClassPokemonCalculationTrait;
    use ClassPokemonReleaseTrait;
    use ClassPokemonGoTurnTrait;
    use ClassPokemonTransformTrait;

    /**
    * ID（friendセット時に一意の値をセット）
    * @var string
    */
    protected $id;

    /**
    * ニックネーム
    * @var string (min:1 max:5)
    */
    protected $nickname;

    /**
    * 現在のレベル
    * @var integer (min:2 max:100)
    */
    protected $level;

    /**
    * 覚えている技 (min:1 max:4)
    * @var array [num => [class => (string), remaining => (int), correction => (int)]]
    */
    protected $move = [];

    /**
    * 経験値
    * @var integer
    */
    protected $exp;

    /**
    * 残りHP
    * @var integer
    */
    protected $remaining_hp;

    /**
    * ポケモンの立場
    * @var string (enemy:敵|friend:味方)
    */
    protected $position = 'enemy';

    /**
    * 個体値
    * @var array(value min:0 max:31)
    */
    protected $iv = [];

    /**
    * 努力値
    * @var array
    */
    protected $ev = [];

    /**
    * ランク（バトルステータス）
    * @var array(min:-6, max:6)
    */
    protected $rank = [];

    /**
    * 状態異常
    * @var array [sa_class_name(string) => turn(integer)]
    */
    protected $sa = [];

    /**
    * 状態変化
    * @var array [sc_class_name(string) => ['turn' => turn(integer), 'param' => param(string)]]
    */
    protected $sc = [];

    /**
    * 進化フラグ
    * @var boolean
    */
    protected $evolve_flg = false;

    /**
    * へんしんフラグ
    * @var boolean
    */
    protected $transform_flg = false;

    /**
    * インスタンス作成時に実行される処理
    * @param param:mixed
    * @param transform:object|null::Pokemon
    * @param empty:boolean
    * @return void
    */
    public function __construct($param=null, $transform=null, $empty=false)
    {
        if($empty){
            // 情報取得用の空オブジェクトを要求
            return;
        }
        if(is_object($transform)){
            // へんしん用処理
            $this->transform($param, $transform);
        }else{
            // 初期化
            $this->init($param);
        }
    }
    
    /**
    * 初期化
    * @param param:mixed
    * @return void
    */
    private function init($param)
    {
        // 初期値のセット
        $this->defaultRank();
        $this->defaultIv();
        $this->defaultEv();
        // パラメーターに合わせた分岐
        switch (gettype($param)) {
            /**
            * 新規登場時の処理(レベル指定)
            * @var integer
            */
            case 'integer':
            $this->setLevel($param);
            $this->setDefaultExp();
            $this->setDefaultMove();
            $this->setIv();
            $this->calRemainingHp('reset');
            break;
            /**
            * 進化した際の処理
            * @var object
            */
            case 'object':
            // 進化前のポケモンと一致しているかチェック
            if(is_a($param, $this->before_class ?? null)){
                $this->takeOverAbility($param->export());
            }
            break;
        }
    }

    /**
    * IDの生成（setPositionで呼び出し）
    * @return void
    */
    protected function generateId()
    {
        if(!$this->id){
            $id = substr(bin2hex(random_bytes(16)), 0, 16);
            while(in_array($id, $_SESSION['__pokemon_ids'], true)){
                $id = substr(bin2hex(random_bytes(16)), 0, 16);
            }
            $this->id = $id;
            $_SESSION['__pokemon_ids'][] = $id;
        }
    }

    /**
    * レベルアップ処理
    *
    * @param string|null $msg_id
    * @return void
    */
    protected function actionLevelUp($msg_id=null)
    {
        // メッセージIDの指定があれば、経験値バーのアニメーション用レスポンスをセット(戦闘ポケモンのみ)
        if(
            !is_null($msg_id) &&
            battle_state()->getPokemonId() === $this->id
        ){
            response()->setResponse([
                'param' => 100, # %
                'action' => 'expbar',
            ], $msg_id);
        }
        // 現在のHPを取得
        $before_hp = $this->getStats('HP');
        // レベルアップ
        $this->level++;
        // HPの上昇値分だけ残りHPを加算(ひんし状態を除く)
        if(!isset($this->sa['SaFainting'])){
            $this->calRemainingHp('add', $this->getStats('HP') - $before_hp);
        }
        // メッセージIDを生成
        $msg_id1 = response()->issueMsgId();
        $msg_id2 = response()->issueMsgId();
        // レベルアップアニメーション用レスポンス(戦闘ポケモンのみ)
        if(battle_state()->getPokemonId() === $this->id){
            response()->setResponse([
                'param' => json_encode([
                    'level' => $this->level,
                    'remaining_hp' => $this->getRemainingHp(),
                    'remaining_hp_per' => $this->getRemainingHp('per'),
                    'max_hp' => $this->getStats('HP'),
                ]),
                'action' => 'levelup',
            ], $msg_id1);
            response()->setAutoMessage($msg_id1);
        }
        // レベルアップメッセージ
        response()->setMessage($this->getNickName().'のレベルは'.$this->level.'になった！', $msg_id2);
        // レスポンスデータをセット
        response()->setResponse([
            'toggle' => 'modal',
            'target' => '#'.$msg_id2.'-modal',
        ], $msg_id2);
        // モーダル用のレスポンスをセット
        response()->setModal([
            'id' => $msg_id2,
            'modal' => 'levelup',
            'stats' => $this->getStats(), # 連続レベルアップ時に書き換わるため現在の値をセット
            'pokemon' => $this
        ]);
        // 現在のレベルで習得できる技があるか確認
        $this->checkLevelMove();
        // プレイヤーレベルの更新
        if($this->level > player()->getLevel()){
            player()->levelUp();
        }
    }

    /**
    * 現在インスタンスを出力(引き継ぎ用:進化で使用中)
    *
    * @param string
    * @return array
    */
    public function export($param=null)
    {
        if(empty($param)){
            return [
                'id' => $this->id,                      # ID
                'class_name' => get_class($this),       # クラス名
                'nickname' => $this->nickname,          # ニックネーム
                'level' => $this->level,                # レベル
                'position' => $this->position,          # 立場
                'ev' => $this->ev,                      # 努力値
                'iv' => $this->iv,                      # 個体値
                'exp' => $this->exp,                    # 経験値
                'move' => $this->move,                  # 技
                'sa' => $this->sa,                      # 状態異常
                'remaining_hp' => $this->remaining_hp,  # 残りHP
            ];
        }else{
            // プロパティ指定
            $property = [
                'sc', 'rank'
            ];
            if(in_array($param, $property, true)){
                return $this->$param;
            }
        }
    }

    /**
    * 能力引き継ぎ処理
    *
    * @param before:array
    * @return void
    */
    protected function takeOverAbility($before)
    {
        foreach($before as $key => $val){
            $this->$key = $val;
        }
    }

    /**
    * 全回復
    * @return void
    */
    public function recovery()
    {
        // HP回復
        $this->calRemainingHp('reset');
        // 状態異常解除
        $this->releaseSa();
        // PP回復
        $this->calRemainingPp('reset');
    }

}
