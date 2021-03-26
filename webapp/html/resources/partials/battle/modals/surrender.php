<div class="modal fade" id="surrender-modal" tabindex="-1" role="dialog" aria-labelledby="surrender-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="surrender-modal-title">
                    <i class="fas fa-flag mr-2"></i>降参
                </h5>
                <button type="button" class="close" data-dismiss="modal" data-controls="message-box" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-danger">このバトルの負けを認めますか？</p>
                <small class="text-muted"><i class="fas fa-exclamation-triangle mr-2"></i>降参すると、おこづかいが半分失われます</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-controls="message-box" data-dismiss="modal">閉じる</button>
                <button type="button" name="button" class="btn btn-sm btn-php-dark" data-submit_remote="surrender">降参する</button>
            </div>
        </div>
    </div>
</div>
