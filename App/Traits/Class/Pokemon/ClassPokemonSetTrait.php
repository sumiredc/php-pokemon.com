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
            setMessage('ニックネームは１〜５文字で入力してください');
            return;
        }
        $this->nickname = $nickname;
        setMessage('ニックネームを変更しました');
    }

    /**
    * レベルをセットする
    * @param level:integer
    * @return void
    */
    public function setLevel($level=5)
    {
        // 指定されたレベルをセット
        $this->level = $level;
    }

    /**
    * ポケモンの立場をセットする
    * @param position:string::friend|enemy
    * @return void
    */
    public function setPosition($position='friend')
    {
        // 入力制限
        if(in_array($position, config('pokemon.position'), true)){
            $this->position = $position;
            // 味方の場合はIDを生成
            if($position === 'friend'){
                $this->generateId();
            }
        }
    }

    /**
    * 進化フラグをfalseにする
    * @return void
    */
    public function setEvolveFlgFalse()
    {
        $this->evolve_flg = false;
    }

    /**
    * 初期技をセットする
    * @return void
    */
    protected function setDefaultMove()
    {
        // レベル順に並び替えて取得
        $move_list = $this->level_move;
        $keys = array_column($move_list, 0);
        array_multisort($keys, SORT_ASC, $move_list);
        // 低レベルから順番に技を取得
        foreach($move_list as list($level, $move)){
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
    * @param move:Move:object
    * @param num:integer
    * @return object Move
    */
    public function setMove($move, int $num=0)
    {
        $this->move[] = [
            'class' => get_class($move),
            'remaining' => $move->getPp(),
            'correction' => 0,
        ];
        if(count($this->move) > 4){
            // 技が4つを超過していれば、選択された番号の技を忘れさせる
            if(!isset($this->move[$num])){
                // もし指定番号に技がなければ一番上を忘れさせる
                $num = 0;
            }
            unset($this->move[$num]);
            // 技の添字を採番する
            $this->move = array_values($this->move);
        }
    }

    /**
    * 初期経験値をセットする
    * @return integer
    */
    public function setDefaultExp()
    {
        $this->exp = $this->level ** 3;
    }

    /**
    * 残りHPをセット
    * @param val:integer
    * @return integer
    */
    public function setRemainingHp($val)
    {
        // 0超過、最大HP以下
        if(
            $val > 0 &&
            $this->getStats('HP') >= $val
        ){
            $this->remaining_hp = $val;
        }
    }

    /**
    * 経験値をセット（取得）する
    * @param exp:integer
    * @return void
    */
    public function setExp(int $exp)
    {
        // 次のレベルに必要な経験値を取得
        $next_exp = $this->getReqLevelUpExp();
        // 経験値を加算
        $this->exp += (int)$exp;
        // メッセージIDを生成
        $msg_id = issueMsgId();
        setMessage($this->getNickname().'は経験値を'.$exp.'手に入れた！', $msg_id);
        // レベル上限の確認
        if($this->level >= 100){
            return $this;
        }
        if($next_exp <= $exp){
            $levelup = true;
            /**
            * 次のレベルに必要な経験値を超えている場合
            */
            // レベルアップ処理
            $this->actionLevelUp($msg_id);
            // レベルアップ処理ループ
            while($this->getReqLevelUpExp() < 0){
                // メッセージIDを再生成
                $msg_id = issueMsgId();
                setAutoMessage($msg_id);
                // レベルアップ処理
                $this->actionLevelUp($msg_id);
            }
            // 全レベルアップ処理終了後、メッセージIDを再生成
            $msg_id = issueMsgId();
            setAutoMessage($msg_id);
        }
        // 経験値バーの最終アニメーション用レスポンス
        setResponse([
            'param' => $this->getPerCompNexExp(),
            'action' => 'expbar',
        ], $msg_id);
        // 進化判定
        if(
            isset($levelup) &&
            isset($this->evolve_level) &&
            $this->evolve_level <= $this->level
        ){
            $this->evolve_flg = true;
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
        $this->iv = array_map(function(){
            // 0〜31の間でランダムの数値を割り振る
            return random_int(0, 31);
        }, $this->iv);
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
    * @param class:string
    * @param turn:integer
    * @return array
    */
    public function setSa(string $class, int $turn=0): array
    {
        // ひんしをセット
        if($class === 'SaFainting'){
            $this->sa = [$class => $turn];
            // ランク・状態変化をリセット
            $this->releaseBattleStatsAll();
            // 進化フラグがtureになっていればfalseに変更
            if($this->evolve_flg){
                $this->evolve_flg = false;
            }
            // メッセージの返却
            return [
                'message' => $this->getPrefixName().'は倒れた'
            ];
        }
        // インスタンス化
        $sa = new $class;
        // 状態異常にかかっていない場合
        if(empty($this->sa) && is_a($sa, 'StatusAilment')){
            // 状態異常をセット
            $this->sa[$class] = $turn;
            return [
                'message' => $sa->getSickedMessage($this->getPrefixName()),
                'sa' => $class
            ];
        }
        // 既に同じ状態異常にかかっている
        if(isset($this->sa[$class])){
            return [
                'message' => $sa->getSickedAlreadyMessage($this->getPrefixName())
            ];
        }
        // 失敗
        return [
            'message' => 'しかし上手く決まらなかった'
        ];
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
