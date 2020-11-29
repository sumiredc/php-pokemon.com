<?php # 遠隔操作用隠しフォーム ?>
<form method="post" id="remote-form">
    <input type="hidden" name="action" id="remote-form-action">
    <?php input_token(); ?>
</form>
<footer>
    <p class="small text-center text-light">※ポケットモンスター・ポケモン・Pokemonは任天堂・クリーチャーズ・ゲームフリークの登録商標です。</p>
</footer>
<?php # ロード中 ?>
<div class="now-loading">
    <div class="spinner-box">
        <div class="spinner-border text-danger" role="status"></div>
    </div>
</div>
<?php
# 強制モーダルの読み込み
if(isForceModal()){
    $modal = getForceModal();
    // 既存モーダルを使用しない場合は読み込み
    if(isset($modal['modal'])){
        include($root_path.'/Resources/Partials/'.getPageName(true).'/Modals/'.$modal['modal'].'.php');
    }
    echo '<input type="hidden" id="force-modal" value="'.($modal['existing_modal'] ?? '#'.$modal['id'].'-modal').'">';
}
# 共通モーダルの読み込み
include($root_path.'/Resources/Partials/Common/Modals/Help/help.php');
# テンプレートの読み込み
include($root_path.'/Resources/Partials//Layouts/Templates/template-common.php');
?>
