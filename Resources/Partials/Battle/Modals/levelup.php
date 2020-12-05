<div class="modal fade" id="<?=$modal['id']?>-modal" tabindex="-1" role="dialog" aria-labelledby="<?=$modal['id']?>-modal-title" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="<?=$modal['id']?>-modal-title">
                    <img src="<?=$modal['pokemon']->base64('mini')?>" alt="<?=$modal['pokemon']::NAME?>">
                    <?=$modal['pokemon']->getNickname()?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" data-controls="message-box" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-sm">
                    <tbody>
                        <?php # ステータスは連続レベルアップを考慮してオブジェクトからは参照しない ?>
                        <?php foreach($modal['stats'] as $key => $val): ?>
                            <tr>
                                <th scope="row" class="w-50"><?=transJp($key, 'stats')?></th>
                                <td><?=$val?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-controls="message-box" data-dismiss="modal">閉じる</button>
            </div>
        </div>
    </div>
</div>
