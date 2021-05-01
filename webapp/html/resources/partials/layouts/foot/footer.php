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
if(response()->isForceModal()){
    $force_modal = response()->getForceModal();
    // 既存モーダルを使用しない場合は読み込み
    if(isset($force_modal['modal'])){
        include resources_path('partials/'.getPageName().'/modals/'.$force_modal['modal'].'.php');
    }
    echo '<input type="hidden" id="force-modal" value="'.($force_modal['existing_modal'] ?? '#'.$force_modal['id'].'-modal').'">';
}
# 共通モーダルの読み込み
include resources_path('partials/common/modals/introduction.php');
include resources_path('partials/common/modals/help/help.php');
# トースト用メッセージの出力
foreach(response()->getToastrs() as $toastr){
    echo '<input type="hidden" data-toastr="'.$toastr[0].'" value="'.$toastr[1].'">';
}
# テンプレートの読み込み
include resources_path('partials/layouts/templates/template-common.php');
?>
