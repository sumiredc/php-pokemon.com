<?php
// トレイト
require_once app_path('Classes/Pokedex.php');
require_once app_path('Traits/Class/Player/ClassPlayerItemTrait.php');
require_once app_path('Traits/Class/Player/ClassPlayerBadgeTrait.php');
require_once app_path('Traits/Class/Player/ClassPlayerMoneyTrait.php');
require_once app_path('Traits/Class/Player/ClassPlayerPartyTrait.php');
require_once app_path('Traits/Class/Player/ClassPlayerTrainerTrait.php');
require_once app_path('Traits/Class/Player/ClassPlayerCounterTrait.php');
/**
* プレイヤー情報
*/
class Player
{
    use ClassPlayerItemTrait, ClassPlayerBadgeTrait, ClassPlayerMoneyTrait, ClassPlayerPartyTrait, ClassPlayerTrainerTrait, ClassPlayerCounterTrait;

    public static $error_flg = false;

    /**
    * ユーザーID
    * @var string
    */
    private $id;

    /**
    * 名前
    * @var string
    */
    protected $name = '';

    /**
    * プレイヤーレベル
    * @var integer
    */
    protected $level = 1;

    /**
    * ポケモン図鑑
    * @var object::Pokedex
    */
    protected $pokedex;

    /**
    * 最終更新日時
    * @var string
    */
    protected $updated_at;

    /**
    * 最終保存日時
    * @var string
    */
    protected $saved_at;

    /**
    * @param name:string
    * @return void
    */
    public function __construct($name)
    {
        $this->issueId();
        $this->name = $name;
        $this->pokedex = new Pokedex;
        $this->setDefaultBadges();
    }

    /**
    * プレイヤーIDの発行
    * @return string
    */
    private function issueId()
    {
        // プレイヤーの一覧を取得
        $players = file(storage_path('database/players.csv'));
        // 改行コード（\n）を削除
        $players = array_map(function($id){
            return preg_replace('/\n/', '', $id);
        }, $players);
        $length = 16;
        // 重複チェック
        while(
            empty($this->id) ||
            in_array($this->id, $players, true)
        ){
            // ID生成
            $this->id = substr(str_shuffle(
                str_repeat('23456789ABCDEFGHJKJKMNPQRSTUVWXYZ', $length)
            ), 0, $length);
        }
        // プレイヤー情報をデータベースに登録
        $file = fopen(storage_path('database/players.csv'), 'a');
        // csvに書き込む
        fputcsv($file, [$this->id]);
        // ファイルを閉じる
        fclose($file);
    }

    /**
    * IDの取得
    * @return string
    */
    public function getId(): string
    {
        return $this->id ?? '';
    }

    /**
    * 名前の取得
    * @return string
    */
    public function getName(): string
    {
        return $this->name;
    }

    /**
    * プレイヤーレベルの取得
    * @return integer
    */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
    * プレイヤーレベルを1上昇させる
    * @return void
    */
    public function levelUp(): void
    {
        $this->level++;
    }

    /**
    * 最終保存日時の取得
    * @param format:string
    * @return string
    */
    public function getSavedAt(string $format='Y-m-d H:i:s'): string
    {
        if(empty($this->saved_at)){
            // 未保存
            return '-';
        }else{
            // 最終保存日時をフォーマットに合わせて返却
            $date = new DateTime($this->saved_at);
            return $date->format($format);
        }
    }

    /**
    * 最終更新日時の格納
    * @return void
    */
    public function setUpdatedAt(): void
    {
        // 現在の日時を取得
        $now = new DateTime;
        // 更新前と比較
        if($this->updated_at){
            $old = new DateTime($this->updated_at);
            $old->setTime(0,0,0);
            // 差分が返ってくれば日付変更処理
            if($now->diff($old, true)->format('%a')){
                $this->changeTheDate();
                response()->setToastr('info', '残りトレーナー戦の回数がリセットされました');
            }
        }
        $this->updated_at = $now->format('Y-m-d H:i:s');
    }

    /**
    * 最終保存日時の格納
    * @return void
    */
    public function setSavedAt(): void
    {
        $date = new DateTime;
        $this->saved_at = $date->format('Y-m-d H:i:s');
    }

    /**
    * 日付変更時の処理
    * @return void
    */
    private function changeTheDate()
    {
        // トレーナーとの対戦記録を初期化
        $this->trainers = [];
    }

    /**
    * 図鑑の取得
    * @return object::Pokedex
    */
    public function pokedex(): object
    {
        return $this->pokedex;
    }

}
