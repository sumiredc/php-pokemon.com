<?php
/**
* バトル 攻撃処理関係トレイト
*/
trait ServiceBattleAttackTrait
{
    /**
    * 省略記号
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
    * @param atk:object::Pokemon
    * @param def:object::Pokemon
    * @param move:string::Move
    * @return string::Move
    */
    protected function attack(object $atk, object $def, string $move) :string
    {
        /**
        * ■ 第1ステップ（技の発動）
        */
        if(!$this->attackActivateMove($atk, $def)){
            // 失敗（技発動せず）
            return $move;
        }
        /**
        * ■ 第2ステップ（PP消費処理と「わるあがき」の確認）
        */
        if(!$this->checkEnabledMove($move, $atk)){
            // 悪あがき発動
            response()->setMessage($atk->getPrefixName().'は、出すことのできる技がない');
        }
        /**
        * ■ 第3ステップ（特別技による技の書き換え）
        */
        if(in_array($move, ['MoveMirrorMove', 'MoveMetronome'], true)){
            // 書き換え技に該当
            $rewrite = $this->attackRewriteMove($atk, $def, $move);
            if($rewrite){
                // 成功（技の書き換え）
                $move = $rewrite;
            }else{
                // 失敗
                return $move;
            }
        }
        /**
        * ■ 第4ステップ（チャージ技の確認）
        */
        $charge = $move::charge($atk);
        if($charge){
            // チャージターンなら行動終了
            response()->setMessage($charge);
            return $move;
        }
        /**
        * ■ 第5ステップ（発動する技の確定 → 成功判定 → ダメージ計算）
        */
        $this->attackConfirmMove($atk, $def, $move);
        /**
        * ■ 第6ステップ（技コストの支払い※命中関係なし）
        */
        $move::cost($atk, $def);
        // サービス本体へ技オブジェクトを返却
        return $move;
    }

    /**************************************************************************
    * attack内の段階処理
    **************************************************************************/

    /**
    * ■ 第1ステップ
    * 技発動前に行う確認処理(状態異常・状態変化)
    * @param atk:object::Pokemon
    * @param def:object::Pokemon
    * @return boolean
    */
    private function attackActivateMove(object $atk, object $def): bool
    {
        if(
            !$this->checkBeforeSa($atk) ||
            !$this->checkBeforeSc($atk)
        ){
            // 技の発動 失敗
            return false;
        }else{
            // 技の発動 成功
            return true;
        }
    }

    /**
    * ■ 第3ステップ
    * 特別技による技の書き換え確認
    * @param atk:object::Pokemon
    * @param def:object::Pokemon
    * @param move:string::Move
    * @return mixed
    */
    private function attackRewriteMove(object $atk, object $def, string $move)
    {
        // 「オウムがえし」の特別処理
        if($move === 'MoveMirrorMove'){
            $mirror = $this->exMirrorMove($atk, $def, $move);
            if(!$mirror){
                // 技失敗
                response()->setMessage('しかし上手く決まらなかった');
                return false;
            }else{
                // ミラーした技を返却
                return $mirror;
            }
        }
        // 「ゆびをふる」の特別処理
        if($move === 'MoveMetronome'){
            return $this->exMetronome($atk, $move);
        }
    }

    /**
    * ■ 第5ステップ
    * 発動する技の確定 → 発動からグローバルの補正値計算
    * @param atk:object::Pokemon
    * @param def:object::Pokemon
    * @param move:string::Move
    * @param void
    */
    private function attackConfirmMove(object $atk, object $def, string $move): void
    {
        // 補正値(プロパティ)の初期化
        $this->m = 1;
        // プロパティに攻撃メッセージIDをセット
        $this->atk_msg_id = response()->issueMsgId();
        response()->setMessage(
            $atk->getPrefixName().'は、'.$move::NAME.'を使った！',
            $this->atk_msg_id
        );
        // 「へんしん」の特別処理
        if($move === 'MoveTransform'){
            $this->exTransform($atk, $def, $move);
            return; # 処理終了
        }
        // タイプ相性チェック
        $this->type_comp_msg = $this->checkTypeCompatibility($move::TYPE, $def::TYPES);
        // 「こうかがない」の判定（命中率と威力がnullではなく、タイプ相性補正が０の場合）
        if(
            !is_null($move::ACCURACY) &&
            !is_null($move::POWER) &&
            $this->m === 0
        ){
            // こうかがない
            response()->setMessage($def->getPrefixName().'には効果が無いみたいだ...');
            // 攻撃失敗
            $this->failedMove($atk, $move);
            return; # 処理終了
        }
        // 命中判定
        if(!$this->checkHit($atk, $def, $move)){
            // 攻撃失敗
            $this->failedMove($atk, $move);
            return; # 処理終了
        }
        // 一撃必殺
        if($move::ONE_HIT_KNOCKOUT_FLG){
            $def->calRemainingHp('death');
            // HPバーのアニメーション用レスポンス
            response()->setResponse([
                'param' => $def->getStats('H'),
                'action' => 'hpbar',
                'target' => $def->getPosition(),
            ], $this->atk_msg_id);
            response()->setMessage('一撃必殺');
            return; # 処理終了
        }
        // 壁補正
        $this->checkWall($move, $def);
        // 技を回数分実行
        $times = $move::times();
        for($i = 0; $i < $times; $i++){
            // もし2回目以降（連続技）ならメッセージIDとオートメッセージを生成
            if($i > 0){
                $this->atk_msg_id = response()->issueMsgId();
                response()->setAutoMessage($this->atk_msg_id);
            }
            // 攻撃判定成功時の処理
            $this->attackSuccess($atk, $def, $move);
            // もし途中でどちらか瀕死になれば処理終了
            if(!$def->isFight() || !$def->isFight()){
                $times = $i + 1; # 行なった攻撃回数を上書き
                break;
            }
        }
        // 連続技はヒット回数のメッセージを返却
        if($times > 1){
            response()->setMessage($times.'回当たった');
        }
    }

    /**************************************************************************
    * ステップ内で行う処理
    **************************************************************************/

    /**
    * 攻撃判定成功時の処理
    * @param atk:object::Pokemon
    * @param def:object::Pokemon
    * @param move:string::Move
    * @return void
    */
    private function attackSuccess($atk, $def, $move)
    {
        if($move::FIXED_DAMAGE_FLG){
            /**
            * 固定ダメージ技
            */
            $damage = $move::getFixedDamage($atk, $def, battle_state());
        }else{
            /**
            * 通常技
            */
            // ローカル変数として補正値を準備
            $m = 1;
            // 必要ステータスの取得
            $stats = $this->getStats($move::SPECIES, $atk, $def);
            // ダメージ計算（物理,特殊技）
            if($move::SPECIES !== 'status'){
                // 急所判定
                $critical = $this->calCritical($move::CRITICAL);
                if($critical){
                    // 補正値を乗算
                    $m *= $critical;
                    response()->setMessage('急所に当たった！');
                }
                // 乱数補正値の計算
                $m *= $this->calRandNum();
                // タイプ一致補正の計算
                $this->calMatchType($move::TYPE, $atk::TYPES);
                // 補正込みの技威力を取得(けたぐり等を考慮してnullの場合は1をセット)
                $power = ($move::POWER ?? 1) * $move::powerCorrection($atk, $def);
                // ダメージ計算
                $damage = (int)$this->calDamage(
                    $atk->getLevel(),   # 攻撃ポケモンのレベル
                    $stats['a'],        # 攻撃ポケモンの攻撃値
                    $stats['d'],        # 防御ポケモンの防御値
                    $power,             # 技の威力
                    $this->m * $m,      # 補正値(プロパティ*ローカル)
                );
                // やけど補正
                if(
                    $move::SPECIES === 'physical' &&
                    $atk->getSa() === 'SaBurn'
                ){
                    // 物理且つやけど状態ならダメージを半減
                    $damage *= 0.5;
                }
                // タイプ相性のメッセージを返却
                response()->setMessage($this->type_comp_msg);
            }
        }
        // このターン受けるダメージをポケモンに格納
        battle_state()->setTurnDamage(
            $def->getPosition(), $move::SPECIES, $damage ?? 0
        );
        // ダメージ計算
        $def->calRemainingHp('sub', $damage ?? 0);
        // HPバーのアニメーション用レスポンス
        if(isset($damage)){
            response()->setResponse([
                'param' => $damage,
                'action' => 'hpbar',
                'target' => $def->getPosition(),
            ], $this->atk_msg_id);
        }
        // 反動処理
        $recoil = $move::recoil($atk, $def);
        if($recoil){
            // HPバーのアニメーション用レスポンス
            $recoil_id = response()->issueMsgId();
            response()->setMessage($recoil['message'], $recoil_id);
            response()->setResponse($recoil['response'], $recoil_id);
        }
        // ネコにこばんの特別処理(相手のHPに関係無く発動)
        if($move === 'MovePayDay'){
            $this->exPayDay($atk, $move);
        }
        // 追加効果(相手にHPが残っていれば)
        if($def->getRemainingHp()){
            // 追加効果
            $effects = $this->effectMove($atk, $def, $move);
            // バトル終了
            if(isset($effects['end'])){
                // 終了判定
                response()->setMessage($effects['message']);
                response()->setEmptyMessage('battle-end');
                response()->setResponse(true, 'end');
                return;
            }
            // 能力下降効果
            if(battle_state()->checkField($def->getPosition(), 'FieldMist')){
                // 能力下降確定技であれば失敗メッセージを出力
                if($move::CONFIRM_DEBUFF_FLG){
                    response()->setMessage(
                        FieldMist::getFailedMessage($def->getPrefixName())
                    );
                }
            }else{
                $debuff = $move::debuff($atk, $def);
                if(isset($debuff['message'])){
                    response()->setMessage($debuff['message']);
                }
            }
            // フィールド効果
            if($move::$field){
                // フィールドをセット
                battle_state()->setField(
                    $atk->getPosition(), $move::$field['class'], $move::$field['turn']
                );
            }
            // いかり判定
            if(
                $def->isSc('ScRage') &&
                !empty($damage ?? 0)
            ){
                // いかり発動メッセージをセット
                response()->setMessage(ScRage::getActiveMessage($def->getPrefixName()));
                // こうげきランクを１段階上昇
                response()->setMessage($def->addRank('A', 1));
            }
            return;
        }
    }

    /**
    * 命中判定
    * @param atk:object::Pokemon
    * @param def:object::Pokemon
    * @param move:string::Move
    * @return boolean
    */
    private function checkHit(object $atk, object $def, string $move): bool
    {
        // ふきとばし・ほえるのチェック
        if(in_array($move, ['MoveWhirlwind', 'MoveRoar'], true)){
            if($atk->getLevel() < $def->getLevel()){
                response()->setMessage($def->getPrefixName().'は、平気な顔をしている');
                return false;
            }
        }
        // 相手のチャージ状態による判定チェック
        $charge_move = $def->getChargeMove();
        if(in_array($charge_move, ['MoveFly', 'MoveDig'], true)){
            // 攻撃技が回避できない技リストになければ失敗
            if(!in_array($move, $charge_move::CANT_ESCAPE_MOVE, true)){
                response()->setMessage(
                    $move::getFailedMessage($atk->getPrefixName())
                );
                return false;
            }
        }
        // 一撃必殺技のチェック
        if($move::ONE_HIT_KNOCKOUT_FLG){
            if($atk->getLevel() < $def->getLevel()){
                // 相手の方がレベルが高ければ無効
                response()->setMessage(
                    $move::getOneHitKnockoutFailedMessage($def->getPrefixName())
                );
                return false;
            }
            // レベル差計算を含めた命中率を取得
            $accuracy = $move::getOneHitKnockoutAccuracy($atk, $def);
        }else{
            // 命中率取得
            $accuracy = $move::ACCURACY;
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
            $move === 'MoveCounter' &&
            empty(battle_state()->getTurnDamage($atk->getPosition(), 'physical'))
        ){
            // 自身にこのターン物理ダメージが蓄積していなければ失敗
            response()->setMessage(
                $move::getFailedMessage($atk->getPrefixName())
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
        response()->setMessage(
            $move::getFailedMessage($atk->getPrefixName())
        );
        return false;
    }

    /**
    * ステータス（攻撃値、防御値）の取得
    * @param atk:object::Pokemon
    * @param move:string::Move
    * @return void
    */
    private function failedMove(object $atk, string $move)
    {
        $failed_id = response()->issueMsgId();
        $failed = $move::failed($atk);
        if(isset($failed['message'])){
            response()->setMessage($failed['message'], $failed_id);
        }
        if(isset($failed['response'])){
            response()->setResponse($failed['response'], $failed_id);
        }
    }

    /**
    * 追加効果の処理
    * @param atk:object::Pokemon
    * @param def:object::Pokemon
    * @param move:string::Move
    * @return array|null
    */
    private function effectMove(object $atk, object $def, string $move)
    {
        $effects = $move::effects($atk, $def);
        // メッセージが取得できたらセット
        if(
            isset($effects['message']) &&
            isset($effects['sa'])
        ){
            // 状態異常有り
            $effect_id = response()->issueMsgId();
            response()->setMessage($effects['message'], $effect_id);
            response()->setResponse([
                'param' => json_encode([
                    'name' => $effects['sa']::NAME,
                    'color' => $effects['sa']::COLOR
                ]),
                'action' => 'sa',
                'target' => $def->getPosition()
            ], $effect_id);
        }elseif(isset($effects['message'])){
            // メッセージのみ返却
            response()->setMessage($effects['message']);
        }
        // バトル終了（ふきとばし・ほえる等）
        if(isset($effects['end'])){
            response()->setEmptyMessage('battle-end');
            response()->setResponse(true, 'end');
            // バトル終了判定
            return $effects;
        }
    }

    /**
    * ステータス（攻撃値、防御値）の取得
    * @param species:string
    * @param atk:object::Pokemon
    * @param def:object::Pokemon
    * @return array
    */
    private function getStats(string $species, object $atk, object $def): array
    {
        // 技種類での分岐
        switch ($species) {
            // 物理
            case 'physical':
            $a = $atk->getStatsM('A');
            $d = $def->getStatsM('B');
            break;
            // 特殊
            case 'special':
            $a = $atk->getStatsM('C');
            $d = $def->getStatsM('D');
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
