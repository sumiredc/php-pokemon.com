<!-- Modal -->
<div class="modal fade" id="item-trash-modal" tabindex="-1" role="dialog" aria-labelledby="item-trash-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post" id="item-trash-form">
                <div class="modal-body">
                    <p><span class="font-weight-bolder" id="item-trash-name"></span>をいくつ捨てますか？</p>
                    <div class="form-group">
                        <select class="form-control" name="count"></select>
                    </div>
                </div>
                <div class="modal-footer">
                    <?php input_token(); ?>
                    <input type="hidden" name="action" value="item">
                    <input type="hidden" name="do" value="trash">
                    <input type="hidden" name="order">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">やめる</button>
                    <button type="submit" class="btn btn-sm btn-danger">捨てる</button>
                </div>
            </form>
        </div>
    </div>
</div>
