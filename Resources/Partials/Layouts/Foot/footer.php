<?php # 遠隔操作用隠しフォーム ?>
<form action="" method="post" id="remote-form">
    <input type="hidden" name="action" id="remote-form-action">
    <?php input_token(); ?>
</form>
<footer>
    <p class="small text-center">※ポケットモンスター・ポケモン・Pokemonは任天堂・クリーチャーズ・ゲームフリークの登録商標です。</p>
</footer>
<?php # ロード中 ?>
<div class="now-loading">
    <div class="spinner-box">
        <div class="spinner-border text-danger" role="status"></div>
    </div>
</div>
<?php
# 共通モーダルの読み込み
include($root_path.'/Resources/Partials/Common/Modals/help.php');
?>
