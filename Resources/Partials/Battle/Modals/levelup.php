<!-- Modal -->
<div class="modal fade" id="<?=$modal['id']?>-modal" tabindex="-1" role="dialog" aria-labelledby="<?=$modal['id']?>-modal-title" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="<?=$modal['id']?>-title">ステータス</h5>
                <button type="button" class="close action-message-box" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-sm">
                    <tbody>
                        <?php foreach($modal['stats'] as $key => $val): ?>
                            <tr>
                                <th scope="row" class="w-50"><?=transJp($key)?></th>
                                <td><?=$val?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm action-message-box" data-dismiss="modal">閉じる</button>
            </div>
        </div>
    </div>
</div>
