<?php
$collapses = [
    'about_session',
    'lose_data',
    'howto_battle',
    'earn_money',
    'select_pokemon',
];
?>
<div class="modal fade" id="help-modal" tabindex="-1" role="dialog" aria-labelledby="help-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header theme-head">
                <h5 class="modal-title font-weight-bolder" id="help-modal-title"><i class="fas fa-question-circle mr-2"></i>ヘルプ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php # モーダルボディ開始 ?>
            <div class="modal-body theme-back">
                <?php # アコーディオン開始 ?>
                <div class="accordion" id="help-accordion">
                    <div class="card">
                        <?php foreach($collapses as $num => $collapse): ?>
                            <?php include resources_path('partials/common/modals/help/partials/'.$collapse.'.php'); ?>
                        <?php endforeach; ?>
                    </div>
                </div><?php # アコーディオン終了 ?>
            </div><?php # モーダルボディ終了 ?>
            <div class="modal-footer theme-foot">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">閉じる</button>
            </div>
        </div>
    </div>
</div>
