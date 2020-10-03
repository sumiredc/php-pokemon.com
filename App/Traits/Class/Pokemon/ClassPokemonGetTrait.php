<?php
trait ClassPokemonGetTrait
{

    /**
    * 詳細を取得する
    * @return integer
    */
    public function getDetails()
    {
        return [
            'Name' => $this->getName(),
            'Nickname' => $this->getNickName(),
            'Type' => $this->getTypes('string'),
            'Level' => $this->getLevel(),
            'Exp' => $this->getExp(),
            'NextLevel' => $this->getReqLevelUpExp(),
        ];
    }

    /**
    * 正式名称を取得する
    * @return string
    */
    public function getName()
    {
        return $this->name;
    }

    /**
    * 名前の手前に接頭語を付ける（相手の）
    * @return string
    */
    public function getPrefixName()
    {
        if($this->position === 'enemy'){
            return '相手の'.$this->name;
        }else{
            return $this->name;
        }
    }

    /**
    * ニックネームを取得する
    * @return string
    */
    public function getNickname()
    {
        if(empty($this->nickname)){
            return $this->name;
        }
        return $this->nickname;
    }

    /**
    * 立場を取得する
    * @return string
    */
    public function getPosition()
    {
        return $this->position;
    }

    /**
    * 覚えている技の一覧を取得する
    * @param integer $num
    * @param string
    * @return array
    */
    public function getMove($num=null, $param='')
    {
        if(is_null($num)){
            // 全返却
            if($param === 'array'){
                // 配列（加工不要）で返却
                return $this->move;
            }else{
                // array_mapで配列内の技クラスをオブジェクト化して返却
                return array_map(function($move){
                    // 無名関数
                    return [
                        'class' => new $move['class'],
                        'remaining' => $move['remaining'],
                        'correction' => $move['correction'],
                    ];
                }, $this->move);
            }
        }else{
            // 番号指定で返却
            $move = $this->move[$num] ?? $this->move[0];
            if($param === 'array'){
                // 配列（加工不要）で返却
                return $move;
            }else{
                // オブジェクトにして返却
                return new $move['class'];
            }
        }

    }

    /**
    * 現在のレベルを取得する
    * @return integer
    */
    public function getLevel()
    {
        return $this->level;
    }

    /**
    * 現在の経験値を取得する
    * @return integer
    */
    public function getExp()
    {
        return $this->exp;
    }

    /**
    * 基礎経験値を取得する
    * @return integer
    */
    public function getBaseExp()
    {
        return $this->base_exp;
    }

    /**
    * 獲得努力値を取得する
    * @return array
    */
    public function getEv()
    {
        return $this->ev;
    }

    /**
    * 獲得努力値を取得する
    * @return array
    */
    public function getRewardEv()
    {
        return $this->reward_ev;
    }

    /**
    * 次のレベルに必要な経験値
    * @return integer
    */
    public function getReqLevelUpExp()
    {
        if($this->level >= 100){
            return 0;
        }
        return ($this->level + 1) ** 3 - $this->exp;
    }

    /**
    * 現在のレベルから次のレベルまでの経験値達成率
    * @return integer
    */
    public function getPerCompNexExp()
    {
        if($this->level >= 100){
            return 100;
        }
        // 現在のレベルので経験値達成率を％の数値で返却（int）
        // 現在のレベルで必要な経験値の超過分（余り）
        $surplus = $this->exp - ($this->level ** 3);
        // 現在のレベルから次のレベルに必要な経験値量
        $need = ((($this->level + 1) ** 3) - ($this->level ** 3));
        // 割合計算（％の数値で返却）
        return $surplus / $need * 100;
    }

    /**
    * 現在の状態異常を取得する
    * @param string (class|turn)
    * @return string
    */
    public function getSa($param='class')
    {
        if(empty($this->sa)){
            return '';
        }
        // 取得対象の分岐
        if($param === 'turn'){
            // 経過ターン数を返却
            return $this->sa[array_key_first($this->sa)];
        }else{
            // クラス名を返却
            return array_key_first($this->sa);
        }
    }

    /**
    * 現在の状態変化を取得する
    * @return array
    */
    public function getSc()
    {
        return $this->sc;
    }

    /**
    * 残りHPを取得
    * @return string $param
    * @return integer
    */
    public function getRemainingHp($param='')
    {
        if($param === 'per'){
            // 最大HPとの比率を%で取得(数値で返却)
            return $this->remaining_hp / $this->getStats('HP') * 100;
        }else{
            return $this->remaining_hp;
        }
    }

    /**
    * 現在の状態異常（Sa）の名称を取得する
    * @return string
    */
    public function getSaName($fainting=true)
    {
        if(empty($this->sa)){
            return '';
        }
        // ひんしの場合は不要（バトル画面など）
        if(!$fainting && (array_key_first($this->sa) === 'SaFainting')){
            return '';
        }
        $sa = $this->getInstance(array_key_first($this->sa));
        if($sa){
            return $sa->getName();
        }
    }

    /**
    * ステータスの取得
    *
    * @param string|null
    * @return array|integer
    */
    public function getStats($param=null, $m=false)
    {
        // ポケモンのステータス（実数値）を計算して返却
        foreach($this->base_stats as $key => $val){
            /**
            * ステータスの計算式（小数点以下は切り捨て）
            * HP：(種族値×2+個体値+努力値÷4)×レベル÷100+レベル+10
            * HP以外：(種族値×2+個体値+努力値÷4)×レベル÷100+5
            */
            if($key === 'HP'){
                $correction = $this->level + 10;
            }else{
                $correction = 5;
            }
            $stats[$key] = (int)(($val * 2 + $this->iv[$key] + $this->ev[$key] / 4) * $this->level / 100 + $correction);
        }
        if(is_null($param)){
            // 指定がなければ全ステータスを返却
            return $stats;
        }
        /**
        * 補正値の計算
        */
        $result = $stats[$param];
        if($m){
            // ランク補正
            $rank = $this->getRank($param);
            if($rank >= 0){
                // +補正
                $per = ($rank + 2) / 2;
            }else{
                // -補正
                $per = 2 / (2 - $rank);
            }
            $result *= round($per, 2); # 補正割合は四捨五入
            // 状態異常補正
            if(($param === 'Speed') && $this->getSa() === 'SaParalysis'){
                // すばやさ半減
                $result *= 0.5;
            }
        }
        return (int)$result; # 実数値は切り捨て
    }

    /**
    * ランク（バトルステータス）の取得
    *
    * @param string|null
    * @return array|integer
    */
    public function getRank($param=null)
    {
        // ランクを変数に格納
        $rank = $this->rank;
        /**
        * ロケットずつき待機中は防御＋1補正
        *
        * 1.チャージ状態
        * 2.ロケットずつきのチャージ状態
        * 3.ぼうぎょランクが+6以外
        */
        $sc = $this->getSc();
        if(isset($sc['ScCharge']) && ($sc['ScCharge']['param'] === 'SkullBash') && ($rank['Defense'] !== 6)){
            $rank['Defense']++;
        }
        // パラメーターに合わせた返り値の分岐
        if(is_null($param)){
            return $rank;
        }else{
            return $rank[$param];
        }
    }

    /**
    * タイプの取得
    *
    * @param string|array|object|null $return
    * @var mixed
    */
    public function getTypes($return=null)
    {
        if(is_null($return)){
            // 引数指定がなければそのまま返却
            return $this->types;
        }
        /**
        * タイプ名の取得用関数
        * @param object
        * @var string
        */
        function getTypesName($obj){
            return $obj->getName();
        }
        // array_mapで配列内のタイプクラスをインスタンス化
        $types = array_map([$this, 'getInstance'], $this->types);
        switch ($return) {
            case 'string':
            // array_mapでタイプ名の配列にしたものを、implodeで文字列に変換
            $types = implode(',', array_map('getTypesName', $types));
            break;
            case 'array':
            // array_mapでタイプ名の配列にして返却
            $types = array_map('getTypesName', $types);
            break;
        }
        return $types;
    }

    /**
    * チャージ技を取得
    * @return string
    */
    public function getChargeMove()
    {
        $sc = $this->getSc();
        return $sc['ScCharge']['param'] ?? '';
    }

}
