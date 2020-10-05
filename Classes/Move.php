<?php
$root_path = __DIR__.'/..';
require_once($root_path.'/App/Traits/InstanceTrait.php');
require_once($root_path.'/App/Traits/ResponseTrait.php');

// 技
abstract class Move
{
    use InstanceTrait;
    use ResponseTrait;

    /**
    * チャージ技確認用フラグ
    * @var boolean
    */
    protected $charge_flg = false;

    /**
    * 一撃必殺確認用フラグ
    * @var boolean
    */
    protected $one_hit_knockout_flg = false;

    /**
    * 攻撃失敗時のメッセージ
    * @var string
    */
    protected $failed_msg = 'しかし::pokemonの攻撃は外れた！';

    /**
    * 一撃必殺失敗時のメッセージ
    * @var string
    */
    protected $one_hit_knockout_failed_msg = '::pokemonには全然効いていない！';

    /**
    * インスタンス作成時に実行される処理
    *
    * @return void
    */
    public function __construct()
    {
        //
    }

    /**
    * チャージ効果
    *
    * @return void
    */
    public function charge($atk)
    {
        // チャージ不要
        return false;
    }

    /**
    * 技回数
    *
    * @return integer
    */
    public function times()
    {
        // デフォルトは1
        return 1;
    }

    /**
    * 追加効果（ダメージ計算後に実行）
    *
    * @return void
    */
    public function effects(...$args)
    {
        //
    }

    /**
    * 名称の取得
    *
    * @return string
    */
    public function getName()
    {
        return $this->name;
    }

    /**
    * 説明文の取得
    *
    * @return string
    */
    public function getDescription()
    {
        return $this->description;
    }

    /**
    * タイプの取得
    *
    * @return object
    */
    public function getType()
    {
        return $this->getInstance($this->type);
    }

    /**
    * 分類の取得
    *
    * @return string
    */
    public function getSpecies()
    {
        return $this->species;
    }

    /**
    * 威力の取得
    *
    * @return string
    */
    public function getPower()
    {
        return $this->power;
    }

    /**
    * 命中率の取得
    *
    * @return integer
    */
    public function getAccuracy()
    {
        return $this->accuracy;
    }

    /**
    * 一撃必殺の命中率を計算
    *
    * @param string $pokemon
    * @return integer
    */
    public function getOneHitKnockoutAccuracy($atk, $def)
    {
        if($atk->getLevel() > $def->getLevel()){
            return $this->accuracy + ($atk->getLevel() - $def->getLevel());
        }
        return $this->accuracy;
    }

    /**
    * 使用回数の取得
    *
    * @param integer $correction 補正値
    * @return integer
    */
    public function getPp(int $correction=0)
    {
        return $this->pp + (int)(floor($this->pp / 5) * $correction);
    }

    /**
    * 優先度の取得
    *
    * @return integer
    */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
    * 急所ランクの取得
    *
    * @return integer
    */
    public function getCritical()
    {
        return $this->critical ?? 0;
    }

    /**
    * チャージフラグの取得
    *
    * @return boolean
    */
    public function getChargeFlg()
    {
        return $this->charge_flg;
    }

    /**
    * 一撃必殺フラグの取得
    *
    * @return boolean
    */
    public function getOneHitKnockoutFlg()
    {
        return $this->one_hit_knockout_flg;
    }

    /**
    * 攻撃失敗時のメッセージを取得
    *
    * @param string $pokemon
    * @return string
    */
    public function getFailedMessage($pokemon)
    {
        return str_replace('::pokemon', $pokemon, $this->failed_msg);
    }

    /**
    * 一撃必殺失敗時（命中率が０）のメッセージを取得
    *
    * @param string $pokemon
    * @return string
    */
    public function getOneHitKnockoutFailedMessage($pokemon)
    {
        return str_replace('::pokemon', $pokemon, $this->one_hit_knockout_failed_msg);
    }

}
