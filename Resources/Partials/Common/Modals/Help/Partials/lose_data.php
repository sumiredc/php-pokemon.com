<?php # データの消失について ?>
<div id="help-accordion-<?=$num?>-head" class="card-header" data-toggle="collapse" data-target="#help-accordion-<?=$num?>-content" aria-expanded="true" aria-controls="help-accordion-<?=$num?>-content" style="cursor: pointer;">
    データの消失について
</div>
<div id="help-accordion-<?=$num?>-content" class="collapse" aria-labelledby="help-accordion-<?=$num?>-head" data-parent="#help-accordion">
    <div class="card-body">
        <h5 class="card-title text-php-head">データが消失することがあります</h5>
        <p class="card-text">
            セッションの有効期限とは別に、データが消失することがあります。これは、システム內部の変更により現在のセッション構成ではエラーが出る場合に起こります。※クラス名の変更など<br>
            本来であれば引き継ぎができるようにデータの書き換え処理を行うところですが、現在はα版ということもあり予告なくデータの削除を実行します。ご了承ください。
        </p>
    </div>
</div>
