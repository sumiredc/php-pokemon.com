<?php

/**
* ホームコントローラー用トレイト
*/
trait HomeControllerTrait
{

    /**
    * ショップ情報の取得
    * @return array
    */
    public function getShop()
    {
        // carry初期値
        $initial = array_map(function(){
            return [];
        }, array_flip(config('item.categories')));
        // カテゴリ分け
        $items = array_reduce(config('shop'), function($carry, $class){
            $carry[$class::CATEGORY][] = [
                'order' => array_search($class, config('shop')), # ショップ内のアイテム番号
                'class' => $class,
                'owned' => player()->getItemCount($class), # 所有数
            ];
            return $carry;
        }, $initial);
        // 空カテゴリを除いて返却
        return array_filter($items, function($item){
            return !empty($item);
        });
    }

    /**
    * バトル開始(野生)の検証
    * @return boolean
    */
    protected function validationBattle(): bool
    {
        // バトル開始可能な状態かを確認
        if(!player()->isFightParty()){
            response()->setMessage('バトルに参加できるポケモンがいないので、フィールドには出れません');
            return false;
        }
        // フィールド情報・プレイヤーレベルの確認
        if(
            empty(config('field.'.request('field'))) ||
            player()->getLevel() < config('field.'.request('field').'.level')
        ){
            response()->setMessage('プレイヤーレベルが足りていません');
            return false;
        }
        return true;
    }

    /**
    * バトル開始(トレーナー)の検証
    * @return boolean
    */
    protected function validationBattleTrainer(): bool
    {
        // バトル開始可能な状態かを確認
        if(!player()->isFightParty()){
            response()->setMessage('バトルに参加できるポケモンがいないので、戦えません');
            return false;
        }
        // トレーナー情報・プレイヤーレベルの確認
        if(
            empty(config('trainer.'.request('trainer'))) ||
            player()->getLevel() < config('trainer.'.request('trainer').'.level')
        ){
            response()->setMessage('プレイヤーレベルが足りていません');
            return false;
        }
        // 残り回数の確認
        if(!player()->isFightTrainer(request('trainer'))){
            response()->setMessage('本日のバトル上限回数を越えています');
            return false;
        }
        return true;
    }

}
