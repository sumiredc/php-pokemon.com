<?php # データの保存について ?>
<div id="help-accordion-<?=$num?>-head" class="card-header" data-toggle="collapse" data-target="#help-accordion-<?=$num?>-content" aria-expanded="true" aria-controls="help-accordion-<?=$num?>-content" style="cursor: pointer;">
    データの保存について
</div>
<div id="help-accordion-<?=$num?>-content" class="collapse" aria-labelledby="help-accordion-<?=$num?>-head" data-parent="#help-accordion">
    <div class="card-body">
        <h5 class="card-title text-php-head">有効期限は24時間です</h5>
        <p class="card-text">
            PHPポケモンはデータベースではなく、セッションに必要なデータを保存して管理しています。その関係上、セッションの有効期限が切れてしまうとデータが消失します。<br>
            セッションの有効期限は24時間で設定しておりますので、24時間操作がなければデータが消失してしまいます。24時間以内に操作があれば、新しくセッションが生成されるため、ユーザー側のブラウザでクッキー削除などを行わなければデータが消失することはありません。
        </p>
    </div>
</div>
