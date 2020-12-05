<?php
// クラス
require_once(root_path('Classes').'PokemonTransform.php');
// トレイト
require_once(app_path('Traits.Class.Pokemon').'ClassPokemonInitTrait.php');
require_once(app_path('Traits.Class.Pokemon').'ClassPokemonSetTrait.php');
require_once(app_path('Traits.Class.Pokemon').'ClassPokemonGetTrait.php');
require_once(app_path('Traits.Class.Pokemon').'ClassPokemonIsTrait.php');
require_once(app_path('Traits.Class.Pokemon').'ClassPokemonCalculationTrait.php');
require_once(app_path('Traits.Class.Pokemon').'ClassPokemonReleaseTrait.php');
require_once(app_path('Traits.Class.Pokemon').'ClassPokemonGoTurnTrait.php');
require_once(app_path('Traits.Class.Pokemon').'ClassPokemonBattleTrait.php');

// ポケモン
abstract class Pokemon
{

    use ClassPokemonInitTrait;
    use ClassPokemonSetTrait;
    use ClassPokemonGetTrait;
    use ClassPokemonIsTrait;
    use ClassPokemonCalculationTrait;
    use ClassPokemonReleaseTrait;
    use ClassPokemonGoTurnTrait;
    use ClassPokemonBattleTrait;

    public const EVOLVE_LEVEL = null;
    public static $before_class = '';
    public static $after_class = '';

    /**
    * ID（friendセット時に一意の値をセット）
    * @var string
    */
    protected $id = '';

    /**
    * ニックネーム
    * @var string
    */
    protected $nickname;

    /**
    * 現在のレベル
    * @var integer::min:2|max:100
    */
    protected $level;

    /**
    * 覚えている技（最大４つまで）
    * @var array::[order:integer=>[class=>string,remaining=>integer,correction=>integer]]
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
    * @var string::enemy|friend
    */
    protected $position = 'enemy';

    /**
    * 個体値
    * @var array::value:min:0|max:31
    */
    protected $iv = [];

    /**
    * 努力値
    * @var array
    */
    protected $ev = [];

    /**
    * ランク（バトルステータス）
    * @var array::value:min:-6|max:6
    */
    protected $rank = [];

    /**
    * 状態異常
    * @var array::[string:class=>integer:turn]
    */
    protected $sa = [];

    /**
    * 状態変化
    * @var array::[string:class=>[integer:turn,string:param]]
    */
    protected $sc = [];

    /**
    * 進化フラグ
    * @var boolean
    */
    protected $evolve_flg = false;

    /**
    * インスタンス作成時に実行される処理
    * @param param:mixed::level:integer|evolve:object::Pokemon
    * @return void
    */
    public function __construct($param=5)
    {
        if(is_a($param, static::$before_class)){
            // 進化
            $this->evolve($param);
        }else{
            // 初期化
            $this->init($param);
        }
    }

    /**
    * 初期化
    * @param level:integer
    * @return void
    */
    private function init(int $level): void
    {
        // 初期値のセット
        $this->setLevel($level);
        $this->setDefaultExp();
        $this->setDefaultMove();
        $this->initIv();
        $this->initEv();
        $this->calRemainingHp('init');
        // バトル用ステータスの準備
        $this->initBattleStats();
    }

    /**
    * 進化
    * @param before:object::Pokemon
    * @return void
    */
    private function evolve(object $before): void
    {
        $this->id = $before->getId();                      # ID
        $this->level = $before->getLevel();                # レベル
        $this->position = $before->getPosition();          # 立場
        $this->ev = $before->getEv();                      # 努力値
        $this->iv = $before->getIv();                      # 個体値
        $this->exp = $before->getExp();                    # 経験値
        $this->move = $before->getMove();                  # 技
        $this->sa = $before->getSa('all');                 # 状態異常
        $this->remaining_hp = $before->getRemainingHp();   # 残りHP
        // ポケモン名とニックネームが異なる場合のみ
        if($before->getNickname() !== $before::NAME){
            $this->nickname = $before->getNickname();      # ニックネーム
        }
        // バトル用ステータスの準備
        $this->initBattleStats();
    }

    /**
    * IDの生成（setPositionで呼び出し）
    * @return string
    */
    protected function generateId(): string
    {
        if(!$this->id){
            $id = substr(bin2hex(random_bytes(16)), 0, 16);
            while(in_array($id, $_SESSION['__pokemon_ids'], true)){
                $id = substr(bin2hex(random_bytes(16)), 0, 16);
            }
            $this->id = $id;
            $_SESSION['__pokemon_ids'][] = $id;
        }
        return $id;
    }

    /**
    * レベルアップ処理
    *
    * @param msg_id::string|null
    * @return void
    */
    protected function actionLevelUp($msg_id=null): void
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
        $before_hp = $this->getStats('H');
        // レベルアップ
        $this->level++;
        // HPの上昇値分だけ残りHPを加算(ひんし状態を除く)
        if($this->isFight()){
            $this->calRemainingHp('add', $this->getStats('H') - $before_hp);
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
                    'max_hp' => $this->getStats('H'),
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
            'stats' => $this->getStatsAll(), # 連続レベルアップ時に書き換わるため現在の値をセット(実数値)
            'pokemon' => $this
        ]);
        // 現在のレベルで習得できる技があるか確認
        $this->isLevelMove();
        // プレイヤーレベルの更新
        if($this->level > player()->getLevel()){
            player()->levelUp();
        }
    }

    // /**
    // * 現在インスタンスを出力(引き継ぎ用:進化で使用中)
    // *
    // * @param string
    // * @return array
    // */
    // public function export($param=null)
    // {
    //     if(empty($param)){
    //         return [
    //             'id' => $this->id,                      # ID
    //             'class_name' => get_class($this),       # クラス名
    //             'nickname' => $this->nickname,          # ニックネーム
    //             'level' => $this->level,                # レベル
    //             'position' => $this->position,          # 立場
    //             'ev' => $this->ev,                      # 努力値
    //             'iv' => $this->iv,                      # 個体値
    //             'exp' => $this->exp,                    # 経験値
    //             'move' => $this->move,                  # 技
    //             'sa' => $this->sa,                      # 状態異常
    //             'remaining_hp' => $this->remaining_hp,  # 残りHP
    //         ];
    //     }else{
    //         // プロパティ指定
    //         $property = [
    //             'sc', 'rank'
    //         ];
    //         if(in_array($param, $property, true)){
    //             return $this->$param;
    //         }
    //     }
    // }

    // /**
    // * 能力引き継ぎ処理
    // *
    // * @param before:array
    // * @return void
    // */
    // protected function takeOverAbility($before)
    // {
    //     foreach($before as $key => $val){
    //         $this->$key = $val;
    //     }
    // }

    /**
    * 全回復
    * @return void
    */
    public function recovery()
    {
        // HP回復
        $this->calRemainingHp('init');
        // 全技PP回復
        $this->calRemainingPpAll('init');
        // 状態異常解除
        $this->initSa();
        // バトルステータスの
        $this->initBattleStats();
    }

}
