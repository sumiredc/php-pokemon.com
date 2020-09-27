<?php
// 敵ポケモンの行動AI
trait EnemyAiTrait
{
    /**
    * 技の選択
    *
    * @return string
    */
    protected function aiSelectMove()
    {
        // 技の一覧を配列形式で取得
        $move = $this->enemy
        ->getMove('array');
        // ランダムで1つ返却
        return $move[array_rand($move)];
    }

}
