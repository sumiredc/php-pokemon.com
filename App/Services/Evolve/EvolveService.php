<?php
$root_path = __DIR__.'/../../..';
// 親クラス
require_once($root_path.'/App/Services/Service.php');
// トレイト
require_once($root_path.'/App/Traits/Service/Common/ServiceCommonRegistPokedexTrait.php');

/**
 * 進化用サービス
 */
class EvolveService extends Service
{

    use ServiceCommonRegistPokedexTrait;

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
    * @param order:integer
    * @return void
    */
    public function __construct($order)
    {
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
    * 進化
    *
    * @return void
    */
    private function evolve()
    {
        // 対象ポケモンの取得
        $before = player()->getParty()[$this->order];
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
            response()->setMessage('おめでとう！'.$before->getNickName().'は'.$after->getName().'に進化した！');
            // 図鑑登録(トレイト：ServiceCommonRegistPokedexTrait)
            $this->setModalRegistPokedex($after);
            // 進化後のインスタンスをパーティーにセット
            player()->evolvePartner($this->order, $after);
            // 現在のレベルで習得できる技があるかチェック
            if($after->getLevelMoveCount()){
                $after->checkLevelMove();
                $this->process_flg = true;
            }
            // 空メッセージのセット
            response()->setEmptyMessage();
        }else{
            response()->setMessage('このポケモンは進化できません');
        }
    }

}
