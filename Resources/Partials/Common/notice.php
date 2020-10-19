<?php
$notices = [
    ['2020/10/19', 'ヘルプページを増設しました'],
    ['2020/10/19', 'レイアウト変更をしました'],
    ['2020/10/17', '技習得時のバグを修正しました'],
    ['2020/10/16', '経験値取得時のアニメーションを追加しました'],
    ['2020/10/12', 'PHPポケモン（α）を公開しました'],
];
?>
<section>
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
