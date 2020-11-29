<div class="modal fade" id="field-modal" tabindex="-1" role="dialog" aria-labelledby="field-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="field-modal-title">
                    <img src="/Assets/img/player/red/mini/left-move.gif" class="mr-2" alt="プレイヤー" />
                    フィールド
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="select-field-form">
                <div class="modal-body">
                    <figure class="text-center" style="height:160px;">
                        <img src="/Assets/img/fields/route_1.png" alt="フィールド画像" id="select-filed-image" class="rounded-sm">
                    </figure>
                    <div class="form-group">
                        <select class="form-control form-control-sm" name="field">
                            <?php foreach(config('field') as $key => $field): ?>
                                <option value="<?=$key?>" <?php if($field['level'] > player()->getLevel()) echo 'disabled'; ?>><?=$field['name']?>（必要レベル：<?=$field['level']?>）</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <ul class="mb-0 pl-3 small">
                        <li class="text-muted">プレイヤーレベルが必要レベルに達していない場所には行けません</li>
                        <li class="text-muted">プレイヤーレベルは「メニュー」>「プレイヤー名」で確認できます</li>
                        <li class="text-muted">出発すると、野生のポケモンとのバトルが開始されます</li>
                    </ul>
                </div><!-- Modal body -->
                <div class="modal-footer">
                    <input type="hidden" name="action" value="battle">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">戻る</button>
                    <input class="btn btn-sm btn-php-dark" type="submit" value="出発する">
                    <?php input_token(); ?>
                </div>
            </form>
        </div><!-- Modal content -->
    </div><!-- Modal dialog -->
</div><!-- Modal  -->
