<!-- Modal -->
<div class="modal fade" id="reset-modal" tabindex="-1" role="dialog" aria-labelledby="reset-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reset-modal-title">リセット</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>データをリセット（消去）しますか？</p>
                <p class="text-danger">リセットすると現在のデータは消去され、初期画面に戻ります。この操作は取り消すことができません。</p>
            </div>
            <div class="modal-footer">
                <form action="" method="post">
                    <input type="hidden" name="action" value="reset">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                    <input class="btn btn-danger" type="submit" value="リセット">
                    <?php input_token(); ?>
                </form>
            </div>
        </div>
    </div>
</div>
