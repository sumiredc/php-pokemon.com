<?php
$root_path = __DIR__.'/../../..';
// 親クラス
require_once($root_path.'/App/Services/Service.php');

/**
 * バトル開始
 */
class StartService extends Service
{

    /**
    * @var object Pokemon
    */
    protected $enemy;

    /**
    * 野生ポケモン レベル下限
    * @var integer
    */
    protected $min;

    /**
    * 野生ポケモン レベル上限
    * @var integer
    */
    protected $max;

    /**
    * 野生ポケモンリスト
    * @var array
    */
    private $pokemon_list = [
        'Fushigidane',
        'Hitokage',
        'Zenigame',
        'Pikachu',
    ];

    /**
    * @param Pokemon:object $pokemon
    * @return void
    */
    public function __construct($pokemon)
    {
        $level = $pokemon->getLevel();
        // 敵ポケモンのレベル幅を生成
        $this->min = $level - 2;
        if($this->min < 1){
            $this->min = 1;
        }
        $this->max = $level;
    }

    /**
    * @return void
    */
    public function execute()
    {
        // 敵ポケモンを生成
        $this->enemy = new $this->pokemon_list[random_int(0, 3)](
            random_int($this->min, $this->max)
        );
        // $this->enemy = new Kamex(15);
        // 返却値をセット
        setMessage('野生の'.$this->enemy->getName().'が現れた！');
    }
}
