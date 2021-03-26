<div class="modal fade" id="report-modal" tabindex="-1" role="dialog" aria-labelledby="report-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bolder" id="report-modal-title"><i class="fas fa-save mr-2"></i>レポート</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-4 col-sm-3 col-form-label font-weight-bold">
                        <span class="py-1">最終保存日時</span>
                    </label>
                    <div class="col-8 col-sm-9">
                        <p class="form-control-plaintext bg-light rounded-sm py-1 px-2"><?=player()->getSavedAt()?></p>
                    </div>
                </div>
                <p class="mb-0">現在の状態をレポートに書き込みます。前に書かれたレポートに上書きされますがよろしいですか？</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">やめる</button>
                <button type="button" class="btn btn-sm btn-php-dark" data-submit_remote="report">書き込む</button>
            </div>
        </div>
    </div>
</div>
