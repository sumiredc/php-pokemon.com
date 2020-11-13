<?php
trait ServiceBattleAttackTrait
{
    /**
    * 省略記号
    *
    * @var L レベル
    * @var A 攻撃値
    * @var D 防御値
    * @var P 威力
    * @var M 補正値
    */

    /**
    * 補正値
    * @var float 小数点第2位までの数値
    */
    private $m;

    /**
    * タイプ相性メッセージ
    * @var string
    */
    private $type_comp_msg = '';

    /**
    * 攻撃メッセージのパラメーターとして設定するID
    * @var string
    */
    private $atk_msg_id;

    /**
    * 攻撃
    * （攻撃→ダメージ計算→ひんし判定）
    *
    * @param atk_pokemon:object::Pokemon
    * @param def_pokemon:object::Pokemon
    * @param move:object::Move
    * @return object::Move
    */
    protected function attack(object $atk_pokemon, object $def_pokemon, object $move) :object
    {
        // 補正値の初期化
        $this->m = 1;
        // 行動チェック(状態異常・状態変化)
        if(
            !$this->checkBeforeSa($atk_pokemon) ||
            !$this->checkBeforeSc($atk_pokemon)
        ){
            // 行動失敗
            return $move;
        }
        // 「わるあがき」の確認とPP消費処理
        if(!$this->checkEnabledMove($move, $atk_pokemon)){
            setMessage($atk_pokemon->getPrefixName().'は出すことのできる技がない');
        }
        // 「オウムがえし」の特別処理
        if(get_class($move) === 'MoveMirrorMove'){
            $mirror_move = $this->exMirrorMove($atk_pokemon, $def_pokemon, $move);
            if(!$mirror_move){
                // 技失敗
                setMessage('しかし上手く決まらなかった');
                return $move;
            }else{
                // ミラー技をセット
                $move = $mirror_move;
            }
        }
        // 「ゆびをふる」の特別処理
        if(get_class($move) === 'MoveMetronome'){
            $move = $this->exMetronome($atk_pokemon, $move);
        }
        // チャージチェック
        $charge = $move->charge($atk_pokemon);
        if($charge){
            // チャージターンなら行動終了
            setMessage($charge);
            return $move;
        }
        // 攻撃メッセージを格納
        $this->atk_msg_id = issueMsgId();
        setMessage(
            $atk_pokemon->getPrefixName().'は'.$move->getName().'を使った！',
            $this->atk_msg_id
        );
        // 「へんしん」の特別処理
        if(get_class($move) === 'MoveTransform'){
            $this->exTransform($atk_pokemon, $def_pokemon, $move);
            return $move;
        }
        // タイプ相性チェック
        $this->type_comp_msg = $this->checkTypeCompatibility(
            $move->getType(),
            $def_pokemon->getTypes()
        );
        // 「こうかがない」の判定（命中率と威力がnullではなく、タイプ相性補正が０の場合）
        if(
            !is_null($move->getAccuracy()) &&
            !is_null($move->getPower()) &&
            $this->m === 0
        ){
            // こうかがない
            setMessage($def_pokemon->getPrefixName().'には効果が無いみたいだ');
            // 攻撃失敗
            $this->failedMove($atk_pokemon, $move);
            return $move;
        }
        // 命中判定
        if(!$this->checkHit($atk_pokemon, $def_pokemon, $move)){
            // 攻撃失敗
            $this->failedMove($atk_pokemon, $move);
            return $move;
        }
        // 一撃必殺
        if($move->getOneHitKnockoutFlg()){
            $def_pokemon->calRemainingHp('death');
            // HPバーのアニメーション用レスポンス
            setResponse([
                'param' => $def_pokemon->getStats('HP'),
                'action' => 'hpbar',
                'target' => $def_pokemon->getPosition(),
            ], $this->atk_msg_id);
            setMessage('一撃必殺');
            return $move;
        }
        // 壁補正
        $this->checkWall($move, $def_pokemon);
        // 技を回数分実行
        $times = $move->times();
        for($i = 0; $i < $times; $i++){
            // もし2回目以降（連続技）ならメッセージIDとオートメッセージを生成
            if($i > 0){
                $this->atk_msg_id = issueMsgId();
                setAutoMessage($this->atk_msg_id);
            }
            // 攻撃判定成功時の処理
            $this->attackSuccess($atk_pokemon, $def_pokemon, $move);
        }
        // 連続技はヒット回数のメッセージを返却
        if($times > 1){
            setMessage($times.'回当たった');
        }
        // 技オブジェクトを返却
        return $move;
    }

    /**
    * 攻撃判定成功時の処理
    *
    * @param object $atk_pokemon
    * @param object $def_pokemon
    * @param object $move
    * @return void
    */
    private function attackSuccess($atk_pokemon, $def_pokemon, $move)
    {
        if($move->getFixedDamageFlg()){
            /**
            * 固定ダメージ技
            */
            $damage = (int)$move->getFixedDamage($atk_pokemon, $def_pokemon, $this->battle_state);
        }else{
            /**
            * 通常技
            */
            // ローカル変数として補正値を用意
            $m = 1;
            // 必要ステータスの取得
            $stats = $this->getStats($move->getSpecies(), $atk_pokemon, $def_pokemon);
            // ダメージ計算（物理,特殊技）
            if($move->getSpecies() !== 'status'){
                // 急所判定
                $critical = $this->calCritical($move->getCritical());
                if($critical){
                    // 補正値を乗算
                    $m *= $critical;
                    setMessage('急所に当たった！');
                }
                // 乱数補正値の計算
                $m *= $this->calRandNum();
                // タイプ一致補正の計算
                $this->calMatchType($move->getType(), $atk_pokemon->getTypes());
                // 技威力の取得(威力補正込み)
                $power = $move->getPower() * $move->powerCorrection($atk_pokemon, $def_pokemon);
                // ダメージ計算
                $damage = (int)$this->calDamage(
                    $atk_pokemon->getLevel(),   # 攻撃ポケモンのレベル
                    $stats['a'],                # 攻撃ポケモンの攻撃値
                    $stats['d'],                # 防御ポケモンの防御値
                    $power,                     # 技の威力
                    $this->m * $m,              # 補正値(プロパティ*ローカル)
                );
                // やけど補正
                if(
                    $move->getSpecies() === 'physical' &&
                    $atk_pokemon->getSa() === 'SaBurn'
                ){
                    // 物理且つやけど状態ならダメージを半減
                    $damage *= 0.5;
                }
                // タイプ相性のメッセージを返却
                setMessage($this->type_comp_msg);
            }
        }
        // このターン受けるダメージをポケモンに格納
        // $def_pokemon->setTurnDamage($move->getSpecies(), $damage ?? 0);
        $this->battle_state
        ->setTurnDamage(
            $def_pokemon->getPosition(),
            $move->getSpecies(),
            $damage ?? 0
        );
        // ダメージ計算
        $def_pokemon->calRemainingHp('sub', $damage ?? 0);
        // HPバーのアニメーション用レスポンス
        if(isset($damage)){
            setResponse([
                'param' => $damage,
                'action' => 'hpbar',
                'target' => $def_pokemon->getPosition(),
            ], $this->atk_msg_id);
        }
        // 反動処理
        $recoil = $move->recoil($atk_pokemon, $def_pokemon);
        if($recoil){
            // HPバーのアニメーション用レスポンス
            $recoil_id = issueMsgId();
            setMessage($recoil['message'], $recoil_id);
            setResponse($recoil['response'], $recoil_id);
        }
        // ネコにこばんの特別処理(相手のHPに関係無く発動)
        if(get_class($move) === 'MovePayDay'){
            $this->exPayDay($atk_pokemon, $move);
        }
        // 追加効果(相手にHPが残っていれば)
        if($def_pokemon->getRemainingHp()){
            // 追加効果
            $effects = $this->effectMove($atk_pokemon, $def_pokemon, $move);
            // バトル終了
            if(isset($effects['end'])){
                // 終了判定
                setMessage($effects['message']);
                setEmptyMessage('battle-end');
                setResponse(true, 'end');
                return;
            }
            // 能力下降効果
            $field_mist = new FieldMist;
            if($this->battle_state->checkField($def_pokemon->getPosition(), $field_mist)){
                // 能力下降確定技であれば失敗メッセージを出力
                if($move->getConfirmDebuffFlg()){
                    setMessage(
                        $field_mist->getFailedMessage($def_pokemon->getPrefixName())
                    );
                }
            }else{
                $debuff = $move->debuff($atk_pokemon, $def_pokemon);
                if(isset($debuff['message'])){
                    setMessage($debuff['message']);
                }
            }
            // フィールド効果
            if($move->field()){
                $field = $move->field();
                // フィールドをセット
                $this->battle_state
                ->setField(
                    $atk_pokemon->getPosition(),
                    new $field['class'],
                    $field['turn']
                );
            }
            // いかり判定
            if(
                $def_pokemon->checkSc('ScRage') &&
                !empty($damage ?? 0)
            ){
                $rage = new ScRage;
                // いかり発動メッセージをセット
                setMessage(
                    $rage->getActiveMessage($def_pokemon->getPrefixName())
                );
                // こうげきランクを１段階上昇
                setMessage(
                    $def_pokemon->addRank('Attack', 1)
                );
            }
            return;
        }
    }

    /**
    * 命中判定
    *
    * @param object $atk
    * @param object $def
    * @param object $move
    * @return boolean
    */
    private function checkHit($atk, $def, $move)
    {
        // ふきとばし・ほえるのチェック
        if(in_array(get_class($move), ['MoveWhirlwind', 'MoveRoar'], true)){
            if($atk->getLevel() < $def->getLevel()){
                setMessage($def->getPrefixName().'は平気な顔をしている');
                return false;
            }
        }
        // 相手のチャージ状態による判定チェック
        $charge_move_class = $def->getChargeMove();
        if(in_array($charge_move_class, ['MoveFly', 'MoveDig'], true)){
            $charge_move = new $charge_move_class;
            // 攻撃技が回避できない技リストになければ失敗
            if(!in_array(get_class($move), $charge_move->getCantEscapeMove(), true)){
                setMessage(
                    $move->getFailedMessage($atk->getPrefixName())
                );
                return false;
            }
        }
        // 一撃必殺技のチェック
        if($move->getOneHitKnockoutFlg()){
            if($atk->getLevel() < $def->getLevel()){
                // 相手の方がレベルが高ければ無効
                setMessage(
                    $move->getOneHitKnockoutFailedMessage($def->getPrefixName())
                );
                return false;
            }
            // レベル差計算を含めた命中率を取得
            $accuracy = $move->getOneHitKnockoutAccuracy($atk, $def);
        }else{
            // 命中率取得
            $accuracy = $move->getAccuracy();
            // nullの場合は命中率関係無し
            if(is_null($accuracy)){
                return true;
            }
            /**
            * ランク補正
            * 攻撃側の命中率 - 防御側の回避率
            */
            $rank = $atk->getRank('Accuracy') - $def->getRank('Evasion');
            if($rank > 0){
                // プラス補正
                if($rank > 6){
                    // 最大値丸め
                    $rank = 6;
                }
                $per = (3 + $rank) / 3;
            }else{
                // マイナス補正
                if($rank < -6){
                    // 最小値丸め
                    $rank = -6;
                }
                $per = 3 / (3 - $rank);
            }
            // 倍率を切り捨てしてランク補正込みの命中率を算出
            $accuracy *= round($per, 2);
        }
        // カウンターの失敗判定
        if(
            get_class($move) === 'MoveCounter' &&
            // empty($atk->getTurnDamage('physical'))
            empty($this->battle_state->getTurnDamage($atk->getPosition(), 'physical'))
        ){
            // 自身にこのターン物理ダメージが蓄積していなければ失敗
            setMessage(
                $move->getFailedMessage($atk->getPrefixName())
            );
            return false;
        }
        /**
        * 0〜100からランダムで数値を取得して、それより小さければ命中
        * 例：命中80%→random_intで60が生成されたら成功、90なら失敗
        */
        if($accuracy >= random_int(1, 100)){
            // 攻撃成功
            return true;
        }
        // 攻撃失敗
        setMessage(
            $move->getFailedMessage($atk->getPrefixName())
        );
        return false;
    }

    /**
    * ステータス（攻撃値、防御値）の取得
    *
    * @param Pokemon:object $atk
    * @param Move:object $move
    * @return void
    */
    private function failedMove($atk, $move)
    {
        $failed_id = issueMsgId();
        $failed = $move->failed($atk);
        if(isset($failed['message'])){
            setMessage($failed['message'], $failed_id);
        }
        if(isset($failed['response'])){
            setResponse($failed['response'], $failed_id);
        }
    }

    /**
    * 追加効果の処理
    *
    * @param Pokemon:object $atk
    * @param Pokemon:object $def
    * @param Move:object $move
    * @return array
    */
    private function effectMove($atk, $def, $move)
    {
        $effects = $move->effects($atk, $def);
        // メッセージが取得できたらセット
        if(isset($effects['message']) && isset($effects['sa'])){
            // 状態異常有り
            $effect_id = issueMsgId();
            $sa = new $effects['sa'];
            setMessage($effects['message'], $effect_id);
            setResponse([
                'param' => json_encode([
                    'name' => $sa->getName(),
                    'color' => $sa->getColor()
                ]),
                'action' => 'sa',
                'target' => $def->getPosition()
            ], $effect_id);
        }elseif(isset($effects['message'])){
            // メッセージのみ返却
            setMessage($effects['message']);
        }
        // バトル終了（ふきとばし・ほえる等）
        if(isset($effects['end'])){
            setEmptyMessage('battle-end');
            setResponse(true, 'end');
            // バトル終了判定
            return $effects;
        }
    }

    /**
    * ステータス（攻撃値、防御値）の取得
    *
    * @param string $species
    * @param Pokemon:object $atk_pokemon
    * @param Pokemon:object $def_pokemon
    * @return array
    */
    private function getStats($species, $atk_pokemon, $def_pokemon)
    {
        // 技種類での分岐
        switch ($species) {
            // 物理
            case 'physical':
            $a = $atk_pokemon->getStats('Attack', true);
            $d = $def_pokemon->getStats('Defense', true);
            break;
            // 特殊
            case 'special':
            $a = $atk_pokemon->getStats('SpAtk', true);
            $d = $def_pokemon->getStats('SpDef', true);
            break;
            // 変化
            case 'status':
            // ここに変化技の処理
            break;
        }
        // 配列にして返却
        return [
            'a' => $a ?? 0,
            'd' => $d ?? 0,
        ];
    }

}
