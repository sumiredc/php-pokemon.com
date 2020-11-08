<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// ゆびをふる
class MoveMetronome extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'ゆびをふる';

    /**
    * 説明文
    * @var string
    */
    protected $description = 'わざのどれかをランダムで繰り出す。';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'TypeNormal';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    protected $species = 'status';

    /**
    * 威力
    * @var integer|null
    */
    protected $power = null;

    /**
    * 命中率
    * @var integer
    */
    protected $accuracy = null;

    /**
    * 使用回数
    * @var integer|null
    */
    protected $pp = 10;

    /**
    * 対象
    * @var string
    */
    protected $target = 'friend';

    /**
    * ゆびをふる 特殊効果
    * @return object::Move
    */
    public function exMetronome() :object
    {
        // ブラックリスト
        $black_list = [
            // ゆびをふる・オウム返し・わるあがき・ものまね・カウンター・へんしん
            get_class(), 'MoveMirrorMove', 'MoveStruggle', 'MoveMimic', 'MoveCounter', 'MoveTransform'
        ];
        // 技クラスをランダムで取得
        $move_list = glob(__DIR__.'/*.php');
        // クラス名部分のみを抽出した配列に変換
        $move_list = array_map(function($path){
            return preg_replace('/\.php$/', '', basename($path));
        }, $move_list);
        // ブラックリストに登録されたクラスを弾く
        $move_list = array_filter($move_list, function($class) use($black_list){
            return !in_array($class, $black_list, true);
        });
        // リストからランダムにキーを抽出
        $key = array_rand($move_list);
        // 技クラスを返却
        return new $move_list[$key];
    }

}
