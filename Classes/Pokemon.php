<?php
$root_path = __DIR__.'/..';
require_once($root_path.'/Resources/Lang/Translation.php');
// トレイト
require_once($root_path.'/App/Traits/ResponseTrait.php');
require_once($root_path.'/App/Traits/InstanceTrait.php');
require_once($root_path.'/App/Traits/Class/Pokemon/ClassPokemonSetTrait.php');
require_once($root_path.'/App/Traits/Class/Pokemon/ClassPokemonGetTrait.php');
require_once($root_path.'/App/Traits/Class/Pokemon/ClassPokemonResetTrait.php');
require_once($root_path.'/App/Traits/Class/Pokemon/ClassPokemonCheckTrait.php');
require_once($root_path.'/App/Traits/Class/Pokemon/ClassPokemonCalculationTrait.php');

// ポケモン
abstract class Pokemon
{
    use ResponseTrait;
    use InstanceTrait;
    use ClassPokemonSetTrait;
    use ClassPokemonGetTrait;
    use ClassPokemonResetTrait;
    use ClassPokemonCheckTrait;
    use ClassPokemonCalculationTrait;

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
    * このターンに受けた攻撃によるダメージ
    * @var array
    */
    protected $turn_damage = [
        'physical' => 0,
        'special' => 0,
    ];

    /**
    * 個体値
    * @var array(value min:0 max:31)
    */
    protected $iv = [
        'HP' => null,
        'Attack' => null,
        'Defense' => null,
        'SpAtk' => null,
        'SpDef' => null,
        'Speed' => null,
    ];

    /**
    * 努力値
    * @var array
    */
    protected $ev = [
        'HP' => 0,
        'Attack' => 0,
        'Defense' => 0,
        'SpAtk' => 0,
        'SpDef' => 0,
        'Speed' => 0,
    ];

    /**
    * ランク（バトルステータス）
    * @var array(min:-6, max:6)
    */
    protected $rank = [
        'Attack' => 0,
        'Defense' => 0,
        'SpAtk' => 0,
        'SpDef' => 0,
        'Speed' => 0,
        'Critical' => 0,    # 急所率
        'Accuracy' => 0,    # 命中率
        'Evasion' => 0,     # 回避率
    ];

    /**
    * 状態異常（バトル後も継続）
    * SaBurn        やけど
    * SaFreeze      こおり
    * SaParalysis   まひ
    * SaPoison      どく
    * SaBadPoison   もうどく
    * SaSleep       ねむり
    * SaFainting    ひんし
    * @var array [sa_class_name(string) => turn(integer)]
    */
    protected $sa = [];

    /**
    * 状態変化（バトル後リセット）
    * ScConfusion           こんらん
    * ScFlinch              ひるみ
    * ScLeechSeed           やどりぎのタネ
    * ScBind                バインド
    * @var array [sc_class_name(string) => ['turn' => turn(integer), 'param' => param(string)]]
    */
    protected $sc = [];

    /**
    * インスタンス作成時に実行される処理
    *
    * @param object|array|integer
    * @return void
    */
    public function __construct($before=0)
    {
        switch (gettype($before)) {
            /**
            * 新規登場時の処理(レベル指定)
            * @var integer $before
            */
            case 'integer':
            $this->setLevel($before);
            $this->setDefaultExp();
            $this->setDefaultMove();
            $this->setIv();
            $this->calRemainingHp('reset');
            break;
            /**
            * 前の画面からの引き継ぎ
            * @var array $before
            */
            case 'array':
            $this->takeOverAbility($before);
            break;
            /**
            * 進化した際の処理
            * @var object $before
            */
            case 'object':
            // 進化前のポケモンと一致しているかチェック
            if(is_a($before, $this->before_class ?? null)){
                $this->takeOverAbility($before->export());
                // メッセージの引き継ぎ
                $this->setMessage($before->getMessages());
                $this->setMessage($this->name.'に進化した', 'success');
                $this->checkMove();
            }
            break;
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
        // メッセージIDの指定があれば、経験値バーのアニメーション用レスポンスをセット
        if(!is_null($msg_id)){
            $this->setResponse([
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
        $msg_id1 = $this->issueMsgId();
        $msg_id2 = $this->issueMsgId();
        // レベルアップアニメーション用レスポンス
        $this->setResponse([
            'param' => json_encode([
                'level' => $this->level,
                'remaining_hp' => $this->getRemainingHp(),
                'remaining_hp_per' => $this->getRemainingHp('per'),
                'max_hp' => $this->getStats('HP'),
            ]),
            'action' => 'levelup',
        ], $msg_id1);
        $this->setAutoMessage($msg_id1);
        // レベルアップメッセージ
        $this->setMessage($this->getNickName().'のレベルは'.$this->level.'になった！', $msg_id2);
        // レスポンスデータをセット
        $this->setResponse([
            'toggle' => 'modal',
            'target' => '#'.$msg_id2.'-modal',
        ], $msg_id2);
        // モーダル用のレスポンスをセット
        $this->setModal([
            'id' => $msg_id2,
            'modal' => 'levelup',
            'stats' => $this->getStats(),
        ]);
        // 現在のレベルで習得できる技があるか確認
        $this->checkMove();
    }

    /**
    * 進化
    *
    * @return Classes\Pokemon\$after_class
    */
    protected function evolve()
    {
        if(class_exists($this->after_class ?? null)){
            // 現在のHPを取得
            $before_hp = $this->getStats('HP');
            // 進化ポケモンのインスタンスを生成
            $pokemon = new $this->after_class($this);
            // HPの上昇値分だけ残りHPを加算(ひんし状態を除く)
            if(!isset($pokemon->sa['SaFainting'])){
                $pokemon->calRemainingHp('add', $pokemon->getStats('HP') - $before_hp);
            }
            // 進化後のインスタンスを返却
            return $pokemon;
        }else{
            $this->setMessage('このポケモンは進化できません', 'error');
        }
    }

    /**
    * 現在インスタンスを出力(引き継ぎ用)
    *
    * @param string
    * @return array
    */
    public function export($param=null)
    {
        if(empty($param)){
            return [
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
    * @param array $before
    * @return void
    */
    protected function takeOverAbility($before)
    {
        foreach($before as $key => $val){
            $this->$key = $val;
        }
    }

    /**
    * ターンカウントをすすめる（状態異常）
    *
    * @return void
    */
    public function goSaTurn()
    {
        // 状態異常クラスを取得
        $sa = $this->getSa();
        switch ($sa) {
            /**
            * ねむり
            */
            case 'SaSleep':
            // 残ターン数を1マイナス
            $this->sa[$sa]--;
            break;
            /**
            * もうどく
            */
            case 'SaBadPoison':
            // 経過ターン数を1プラス（最大15）
            if($this->sa[$sa] <= 14){
                $this->sa[$sa]++;
            }else{
                $this->sa[$sa] = 15;
            }
            break;
        }
    }

    /**
    * ターンカウントをすすめる（状態変化）
    *
    * @param string $class
    * @return void
    */
    public function goScTurn($class)
    {
        // 状態変化を取得
        $sc = $this->getSc();
        if(isset($sc[$class])){
            // 残ターン数を1マイナス
            $this->sc[$class]['turn']--;
        }
    }

    /**
    * 状態異常の解除
    *
    * @return void
    */
    public function releaseSa()
    {
        if($this->getSa() !== 'SaFainting'){
            $this->sa = [];
        }
    }

    /**
    * 状態変化の解除
    *
    * @param string $class
    * @return void
    */
    public function releaseSc($class='')
    {
        if(empty($class)){
            // 全解除
            $this->sc = [];
        }else{
            // 指定された状態変化の解除
            unset($this->sc[$class]);
        }
    }

}
