<?php
/**
* 格納用トレイト
*/
trait ClassPokemonSetTrait
{

    /**
    * ニックネームを付ける
    * @param string
    * @return boolean
    */
    public function setNickname(string $nickname): bool
    {
        if(
            empty($nickname) ||
            mb_strlen($nickname, 'UTF-8') > 5
        ){
            response()->setMessage('ニックネームは１〜５文字で入力してください');
            return false;
        }else{
            $this->nickname = $nickname;
            response()->setMessage('ニックネームを変更しました');
            return true;
        }
    }

    /**
    * レベルをセットする
    * @param level:integer
    * @return void
    */
    public function setLevel(int $level=5): void
    {
        // 指定されたレベルをセット
        $this->level = $level;
    }

    /**
    * ポケモンの立場をセットする
    * @param position:string::friend|enemy
    * @return void
    */
    public function setPosition($position='friend'): void
    {
        // 入力制限
        if(in_array($position, config('pokemon.position'), true)){
            $this->position = $position;
            // 味方の場合はID生成・図鑑登録
            if($position === 'friend'){
                // ID生成
                $this->generateId();
                // 図鑑登録
                player()->pokedex()
                ->regist($this);
            }
        }
    }

    /**
    * 進化フラグをfalseにする
    * @return void
    */
    public function setEvolveFlgFalse(): void
    {
        $this->evolve_flg = false;
    }

    /**
    * 初期技をセットする
    * @return void
    */
    protected function setDefaultMove(): void
    {
        // レベル順に並び替えて取得(array_multisortが破壊的な関数のため)
        $move_list = static::LEVEL_MOVE;
        $keys = array_column($move_list, 0);
        array_multisort($keys, SORT_ASC, $move_list);
        // 低レベルから順番に技を取得
        foreach($move_list as list($level, $move)){
            if($level > $this->level){
                // 現在レベルを超えていれば処理終了
                break;
            }
            // 技をセット
            $this->setMove($move);
        }
    }

    /**
    * 技を覚える
    * @param move:string
    * @param order:integer
    * @return boolean
    */
    public function setMove(string $move, int $order=0): bool
    {
        // 技クラスの存在チェック
        if(!class_exists($move)){
            return false;
        }
        // 技を追加
        $this->move[] = [
            'class' => $move,
            'remaining' => $move::PP,
            'correction' => 0,
        ];
        if(count($this->move) > 4){
            // 技が4つを超過していれば、選択された番号の技を忘れさせる
            if(!isset($this->move[$order])){
                // もし指定番号に技がなければ0番目を削除
                $order = 0;
            }
            unset($this->move[$order]);
            // 技の添字を採番する
            $this->move = array_values($this->move);
        }
        return true;
    }

    /**
    * 初期経験値をセットする
    * @return void
    */
    public function setDefaultExp(): void
    {
        $this->exp = $this->level ** 3;
    }

    /**
    * 残りHPをセット
    * @param val:integer
    * @return void
    */
    public function setRemainingHp($val): void
    {
        // 0超過、最大HP以下
        if(
            $val > 0 &&
            $this->getStats('H') >= $val
        ){
            $this->remaining_hp = $val;
        }
    }

    /**
    * 経験値をセット（取得）する
    * @param exp:integer
    * @return void
    */
    public function setExp(int $exp): void
    {
        // 次のレベルに必要な経験値を取得
        $next_exp = $this->getReqLevelUpExp();
        // 経験値を加算
        $this->exp += $exp;
        // メッセージIDを生成
        $msg_id = response()->issueMsgId();
        response()->setMessage($this->getNickname().'は経験値を'.$exp.'手に入れた！', $msg_id);
        // レベル上限の確認
        if($this->level >= 100){
            return;
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
                $msg_id = response()->issueMsgId();
                response()->setAutoMessage($msg_id);
                // レベルアップ処理
                $this->actionLevelUp($msg_id);
            }
            // 全レベルアップ処理終了後、メッセージIDを再生成(戦闘ポケモンのみ)
            if(battle_state()->getPokemonId() === $this->id){
                $msg_id = response()->issueMsgId();
                response()->setAutoMessage($msg_id);
            }
        }
        // 経験値バーの最終アニメーション用レスポンス(戦闘ポケモンのみ)
        if(battle_state()->getPokemonId() === $this->id){
            response()->setResponse([
                'param' => $this->getPerCompNexExp(),
                'action' => 'expbar',
            ], $msg_id);
        }
        // 進化判定
        if(
            isset($levelup) &&
            !is_null(static::EVOLVE_LEVEL) &&
            static::EVOLVE_LEVEL <= $this->level
        ){
            $this->evolve_flg = true;
        }
    }

    /**
    * 努力値をセット（取得）する
    * @param reward_ev:array
    * @return void
    */
    public function setEv(array $reward_ev): void
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
    * 状態異常の格納
    * @param class:string
    * @param turn:integer
    * @return array
    */
    public function setSa(string $class, int $turn=0): array
    {
        // ひんしをセット
        if($class === 'SaFainting'){
            $this->sa = [$class => $turn];
            // バトル専用ステータスを全解除
            $this->initBattleStats();
            // 進化フラグがtureになっていればfalseに変更
            if($this->evolve_flg){
                $this->evolve_flg = false;
            }
            // メッセージの返却
            return [
                'message' => $this->getPrefixName().'は倒れた'
            ];
        }
        // 状態異常にかかっていない場合
        if(
            empty($this->sa) &&
            class_exists($class)
        ){
            // 状態異常をセット
            $this->sa[$class] = $turn;
            return [
                'message' => $class::getSickedMessage($this->getPrefixName()),
                'sa' => $class
            ];
        }
        // 既に同じ状態異常にかかっている
        if(isset($this->sa[$class])){
            return [
                'message' => $class::getSickedAlreadyMessage($this->getPrefixName())
            ];
        }
        // 失敗
        return [
            'message' => 'しかし上手く決まらなかった'
        ];
    }

}
