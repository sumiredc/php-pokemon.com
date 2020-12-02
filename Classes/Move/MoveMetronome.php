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
    public const NAME = 'ゆびをふる';

    /**
    * 説明文
    * @var string
    */
    public const DESCTIPTION = 'わざのどれかをランダムで繰り出す。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeNormal';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    public const SPECIES = 'status';

    /**
    * 威力
    * @var integer|null
    */
    public const POWER = null;

    /**
    * 命中率
    * @var integer
    */
    public const ACCURACY = null;

    /**
    * 使用回数
    * @var integer|null
    */
    public const PP = 10;

    /**
    * 対象
    * @var string
    */
    public const TARGET = 'friend';

    /**
    * ゆびをふる 特殊効果
    * @return object::Move
    */
    public static function exMetronome() :object
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
