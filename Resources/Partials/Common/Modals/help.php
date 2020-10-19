<?php
$collapses = [
    'about_session',
    'howto_battle',
];
?>
<div class="modal fade" id="help-modal" tabindex="-1" role="dialog" aria-labelledby="help-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="help-modal-title">ヘルプ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php # モーダルボディ開始 ?>
            <div class="modal-body">
                <?php # アコーディオン開始 ?>
                <div class="accordion mb-3" id="help-accordion">
                    <div class="card">
                        <?php foreach($collapses as $num => $collapse): ?>
                            <?php include($root_path.'/Resources/Partials/Common/Modals/Collapses/'.$collapse.'.php'); ?>
                        <?php endforeach; ?>
                    </div>
                </div><?php # アコーディオン終了 ?>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                </div>
            </div><?php # モーダルボディ終了 ?>
        </div>
    </div>
</div>
