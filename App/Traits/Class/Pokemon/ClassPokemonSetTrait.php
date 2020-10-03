<?php
trait ClassPokemonSetTrait
{

    /**
    * ニックネームを付ける
    * @param string
    * @return void
    */
    public function setNickname($nickname)
    {
        if(empty($nickname) || mb_strlen($nickname, 'UTF-8') > 5){
            $this->setMessage('ニックネームは１〜５文字で入力してください', 'error');
            return;
        }
        $this->nickname = $nickname;
        $this->setMessage('ニックネームを変更しました', 'success');
    }

    /**
    * レベルをセットする
    * @return void
    */
    protected function setLevel()
    {
        // 初期レベルからランダムで値を取得
        $key = array_rand($this->default_level);
        $this->level = $this->default_level[$key];
    }

    /**
    * ポケモンの立場をセットする
    * @param string (friend|enemy)
    * @return void
    */
    public function setPosition($param='friend')
    {
        // 入力制限
        if(in_array($param, ['enemy', 'friend'], true)){
            $this->position = $param;
        }
    }

    /**
    * 初期技をセットする
    * @return void
    */
    protected function setDefaultMove()
    {
        foreach($this->level_move as list($level, $move)){
            if($level <= $this->level){
                // 現在レベル以下の技であれば習得
                $this->setMove(new $move);
            }else{
                // 現在レベルを超えていれば処理終了
                break;
            }
        }
    }

    /**
    * 技を覚える
    * @return object Move
    */
    protected function setMove($move)
    {
        $this->move[] = [
            'class' => get_class($move),
            'remaining' => $move->getPp(),
            'correction' => 0,
        ];
        if(count($this->move) > 4){
            // 技が4つを超過していれば、一番上を忘れさせる
            unset($this->move[0]);
            // 技の添字を採番する
            $this->move = array_values($this->move);
        }
    }

    /**
    * 初期経験値をセットする
    * @return integer
    */
    protected function setDefaultExp()
    {
        $this->exp = $this->level ** 3;
    }

    /**
    * 経験値をセット（取得）する
    * @param integer $exp
    * @return object
    */
    public function setExp($exp)
    {
        if(!is_numeric($exp)){
            // 入力値のチェック
            $this->setMessage('数値を入力してください', 'error');
            return $this;
        }
        // 次のレベルに必要な経験値を取得
        $next_exp = $this->getReqLevelUpExp();
        // 経験値を加算
        $this->exp += (int)$exp;
        $this->setMessage($this->getNickname().'は経験値を'.$exp.'手に入れた！', 'success');
        // レベル上限の確認
        if($this->level >= 100){
            return $this;
        }
        if($next_exp <= $exp){
            $levelup = true;
            /**
            * 次のレベルに必要な経験値を超えている場合
            */
            $this->actionLevelUp();
            while($this->getReqLevelUpExp() < 0){
                $this->actionLevelUp();
            }
        }
        // 進化判定
        if(isset($levelup) && isset($this->evolve_level) && ($this->evolve_level <= $this->level)){
            return $this->evolve();
        }else{
            return $this;
        }
    }

    /**
    * 努力値をセット（取得）する
    * @param array $reward_ev
    * @return void
    */
    public function setEv($reward_ev)
    {
        // 最大努力値合計は510
        if(array_sum($this->ev) >= 510){
            return;
        }
        // 努力値を加算
        foreach($reward_ev as $key => $val){
            $this->ev[$key] += $val;
            // 各ステータスの最大は252
            if($this->ev[$key] > 252){
                $this->ev[$key] = 252;
            }
            // 最大努力値を超過させないための処理
            if(array_sum($this->ev) > 510){
                // 510超過分をセットした努力値から減算
                $this->ev[$key] -= array_sum($this->ev) - 510;
                break;
            }
        }
    }

    /**
    * 個体値をセットする
    * @return void
    */
    protected function setIv()
    {
        /**
        * 個体値のランダム生成（コールバック用）
        * @return integer
        */
        function randIv(){
            // 0〜31の間でランダムの数値を割り振る
            return mt_rand(0, 31);
        }
        $this->iv = array_map('randIv', $this->iv);
    }

    /**
    * ランク（バトルステータス）をセットする
    * @param array|string $rank
    * @return void
    */
    public function setRank($rank)
    {
        // 初期化
        if($rank === 'reset'){
            $this->rank = [
                'Attack' => 0,
                'Defense' => 0,
                'SpAtk' => 0,
                'SpDef' => 0,
                'Speed' => 0,
                'Critical' => 0,
                'Accuracy' => 0,
                'Evasion' => 0,
            ];
            return;
        }
        // ランクをセット
        if(is_array($rank)){
            $this->rank = $rank;
        }
    }

    /**
    * 状態異常をセットする
    * @param string $class
    * @param integer $turn|0
    * @return string
    */
    public function setSa($class, $turn=0)
    {
        // ひんしをセット
        if($class === 'SaFainting'){
            $this->sa = [$class => $turn];
            return $this->getPrefixName().'は倒れた';
        }
        // セットできる状態異常一覧
        $sa_list = [
            'SaBurn', 'SaFreeze', 'SaParalysis', 'SaPoison', 'SaBadPoison', 'SaSleep',
        ];
        // クラスチェック
        if(!in_array($class, $sa_list, true) || !class_exists($class)){
            // 不正なクラス
            return '指定された状態異常は存在しません';
        }
        // 状態異常にかかっていない場合
        if(empty($this->sa)){
            $sa = new $class;
            // 状態異常をセット
            $this->sa[$class] = $turn;
            return $sa->getSickedMessage($this->getPrefixName());
        }
        if(isset($this->sa[$class])){
            $sa = new $class;
            // 既に同じ状態異常にかかっている
            return $sa->getSickedAlreadyMessage($this->getPrefixName());
        }
        return 'しかし上手く決まらなかった';
    }

    /**
    * 状態変化をセットする
    * @param string|array $class
    * @param integer $turn
    * @param string $param
    * @return string
    */
    public function setSc($class, $turn=0, $param='Standard')
    {
        // 状態変化の引き継ぎ処理
        if(is_array($class)){
            $this->sc = $class;
            return;
        }
        // セットできる状態異常一覧
        $sc_list = [
            'ScConfusion', 'ScFlinch', 'ScLeechSeed', 'ScBind', 'ScCharge',
        ];
        // クラスチェック
        if(!in_array($class, $sc_list, true) || !class_exists($class)){
            // 不正なクラス
            return '指定された状態変化は存在しません';
        }
        $sc = new $class;
        // 状態変化のセット確認
        if(isset($this->sc[$class])){
            // 既に同じ状態変化にかかっている
            return $sc->getSickedAlreadyMessage($this->getPrefixName(), $param);
        }else{
            // 状態変化をセット
            $this->sc[$class] = [
                'turn' => $turn,
                'param' => $param,
            ];
            return $sc->getSickedMessage($this->getPrefixName(), $param);
        }
    }

}
