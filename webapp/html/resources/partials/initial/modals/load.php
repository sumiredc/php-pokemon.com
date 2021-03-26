<div class="modal fade" id="load-modal" tabindex="-1" role="dialog" aria-labelledby="load-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bolder" id="load-modal-title"><i class="fas fa-folder-open mr-2"></i>続きから始める</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">プレイヤーID</span>
                        </div>
                        <input type="text" class="form-control" aria-label="プレイヤーID" placeholder="プレイヤーIDを入力してください" aria-describedby="player-id-addon" name="player_id">
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">閉じる</button>
                    <button type="submit" class="btn btn-sm btn-php-dark">読み込み</button>
                </div>
                <input type="hidden" name="action" value="load">
                <?php input_token(); ?>
            </form>
        </div>
    </div>
</div>
