<?php
// クラス
require_once app_path('Classes/PokemonTransform.php');
// トレイト
require_once app_path('Traits/Class/Pokemon/ClassPokemonInitTrait.php');
require_once app_path('Traits/Class/Pokemon/ClassPokemonActionTrait.php');
require_once app_path('Traits/Class/Pokemon/ClassPokemonSetTrait.php');
require_once app_path('Traits/Class/Pokemon/ClassPokemonGetTrait.php');
require_once app_path('Traits/Class/Pokemon/ClassPokemonIsTrait.php');
require_once app_path('Traits/Class/Pokemon/ClassPokemonCalculationTrait.php');
require_once app_path('Traits/Class/Pokemon/ClassPokemonGoTurnTrait.php');
require_once app_path('Traits/Class/Pokemon/ClassPokemonBattleTrait.php');

// ポケモン
abstract class Pokemon
{

    use ClassPokemonInitTrait, ClassPokemonActionTrait, ClassPokemonSetTrait, ClassPokemonGetTrait, ClassPokemonIsTrait, ClassPokemonCalculationTrait, ClassPokemonGoTurnTrait, ClassPokemonBattleTrait;

    /**
    * 定数
    */
    public const EVOLVE_LEVEL = null;
    public const BEFORE_CLASS = null;
    public const AFTER_CLASS = null;

    /**
    * 進化後のクラス（進化先に分岐があるポケモン用）
    * @var string
    */
    protected $after_class = '';

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
        if(is_a($param, static::BEFORE_CLASS)){
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
    * 全回復
    * @return void
    */
    public function recovery(): void
    {
        // HP回復
        $this->calRemainingHp('init');
        // 全技PP回復
        $this->calRemainingPpAll('init');
        // 状態異常解除
        $this->initSa();
        // バトルステータスの初期化
        $this->initBattleStats();
    }

    /**
    * 進化条件の分岐(空メソッド)
    * @param args:array
    * @var boolean
    */
    public function judgeEvolve(...$args): bool
    {
        return false;
    }

}
