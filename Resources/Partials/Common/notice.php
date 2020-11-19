<?php
$notices = [
    ['2020/11/16', '出現する野生ポケモンをレベルに合わせて変わるようにしました'],
    ['2020/11/15', 'フレンドリィショップを開設しました'],
    ['2020/11/14', 'プレイヤーシステムを導入しました'],
    ['2020/10/29', '進化演出を導入しました'],
    ['2020/10/28', 'システム改修のため近日中に全セーブデータのリセットを行います'],
    ['2020/10/19', 'ヘルプページを増設しました'],
    ['2020/10/19', 'システム修正の関係で全セーブデータのリセットを実行しました'],
    ['2020/10/17', '技習得時のバグを修正しました'],
    ['2020/10/16', '経験値取得時のアニメーションを追加しました'],
    ['2020/10/12', 'PHPポケモン（α）を公開しました'],
];
?>
<section class="bg-light p-3">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-3">お知らせ</h2>
            <ul class="list-group list-group-flush mb-3 overflow-auto border border-dark" style="height: 160px;">
                <?php foreach($notices as list($date, $text)): ?>
                <li class="list-group-item">
                    <span class="badge badge-info mr-2"><?=$date?></span><?=$text?>
                 </li>
             <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>
