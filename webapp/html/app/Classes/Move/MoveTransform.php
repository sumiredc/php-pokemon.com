<?php

require_once app_path('Classes/Move.php');

// へんしん
class MoveTransform extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'へんしん';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '相手のポケモンに変身する。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeNormal';

    /**
    * 分類
    * @var string::physical:物理|special:特殊|status:変化
    */
    public const SPECIES = 'status';

    /**
    * 威力
    * @var integer|null
    */
    public const POWER = null;

    /**
    * 命中率
    * @var integer|null
    */
    public const ACCURACY = null;

    /**
    * 使用回数
    * @var integer
    */
    public const PP = 10;

    /**
    * 対象
    * @var string
    */
    public const TARGET = 'enemy';

    /**
    * へんしんの専用効果
    * @param atk:object::Pokemon
    * @param def:object::Pokemon
    * @return void
    */
    public static function exTransform(object $atk, object $def)
    {
        if(!$atk->isSc('ScTransform')){
            // 現在へんしん状態でなければ実行
            $atk->setSc('ScTransform', 0, $atk->transform($def));
            return true;
        }else{
            // 現在へんしん状態であれば失敗
            return false;
        }
    }

}
