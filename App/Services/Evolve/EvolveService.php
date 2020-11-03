<?php
$root_path = __DIR__.'/../../..';
// 親クラス
require_once($root_path.'/App/Services/Service.php');

/**
 * 進化用サービス
 */
class EvolveService extends Service
{

    /**
    * @var array
    */
    private $party;

    /**
    * @var integer
    */
    private $order;

    /**
    * @var boolean
    */
    public $process_flg = false;

    /**
    * @return void
    */
    public function __construct($party, $order)
    {
        $this->party = $party;
        $this->order = $order;
    }

    /**
    * @return void
    */
    public function execute()
    {
        // 進化処理
        $this->evolve();
    }

    /**
    * パーティープロパティの取得
    *
    * @return array
    */
    public function getParty()
    {
        return $this->party;
    }

    /**
    * 進化
    *
    * @return void
    */
    private function evolve()
    {
        // 対象ポケモンの取得
        $before = $this->party[$this->order];
        $after_class = $before->getAfterClass();
        // 対象ポケモンが進化可能な状態か確認
        if(
            $before->getEvolveFlg()
            && class_exists($after_class)
        ){
            // 現在のHPを取得
            $before_hp = $before->getStats('HP');
            // 進化ポケモンのインスタンスを生成
            $after = new $after_class($before);
            // HPの上昇値分だけ残りHPを加算(ひんし状態を除く)
            if(!isset($after->sa['SaFainting'])){
                $after->calRemainingHp('add', $after->getStats('HP') - $before_hp);
            }
            setMessage('おめでとう！'.$before->getNickName().'は'.$after->getName().'に進化した！');
            // 進化後のインスタンスをパーティーにセット
            $this->party[$this->order] = $after;
            // 現在のレベルで習得できる技があるかチェック
            if($after->getLevelMoveCount()){
                $after->checkLevelMove();
                $this->process_flg = true;
            }
            // 空メッセージのセット
            setEmptyMessage();
        }else{
            setMessage('このポケモンは進化できません');
        }
    }

}
