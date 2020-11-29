<!-- Modal -->
<div class="modal fade" id="reset-modal" tabindex="-1" role="dialog" aria-labelledby="reset-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="font-weight text-php-head mb-3">データをリセット（消去）しますか？</h5>
                <p class="text-danger mb-0">リセットすると現在のデータは消去され、初期画面に戻ります。この操作は取り消すことができません。</p>
            </div>
            <div class="modal-footer">
                <form method="post">
                    <input type="hidden" name="action" value="reset">
                    <input class="btn btn-sm btn-danger" type="submit" value="リセット">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">キャンセル</button>
                    <?php input_token(); ?>
                </form>
            </div>
        </div>
    </div>
</div>
