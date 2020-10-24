<!-- Modal -->
<div class="modal fade" id="<?=$modal['id']?>-modal" tabindex="-1" role="dialog" aria-labelledby="<?=$modal['id']?>-modal-title" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="<?=$modal['id']?>-title">忘れさせる技を選ぶ</h5>
            </div>
            <div class="modal-body">
                <?php # 覚えている技 ?>
                <table class="table table-bordered table-sm table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">覚えている技</th>
                            <th scope="col">タイプ</th>
                            <th scope="col">PP</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($modal['move'] as $key => $move): ?>
                            <tr class="move-detail-link forget-selectmove <?php if($key === 4) echo 'active new-move'; ?>"
                                data-target="#<?=$modal['id']?>_<?=get_class($move['class'])?>-content"
                                data-name="<?=$move['class']->getName()?>"
                                data-num="<?=$key?>">
                                <th scope="row" class="w-50"><?=$move['class']->getName()?></th>
                                <td><?=$move['class']->getType()->getName()?></td>
                                <td><?=$move['remaining']?>/<?=$move['class']->getPp($move['correction'])?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php # 技説明 ?>
                <div class="overflow-auto p-3 border" style="height:160px;">
                    <?php foreach($modal['move'] as $key => $move): ?>
                        <div class="move-detail-content <?php if($key === 4) echo 'active'; ?>" id="<?=$modal['id']?>_<?=get_class($move['class'])?>-content">
                            <h6><?=$move['class']->getName()?></h6>
                            <hr>
                            <p><?=$move['class']->getDescription()?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button"
                class="btn btn-danger btn-sm"
                id="btn-forget-move"
                data-msg_id="<?=$modal['id']?>"
                style="display:none;">
                <span class="move-name"></span>を忘れる</button>
                <button type="button" class="btn btn-secondary btn-sm action-message-box" id="btn-abandon-move" data-dismiss="modal">
                    <?=$modal['move'][4]['class']->getName()?>を諦める
                </button>
            </div>
        </div>
    </div>
</div>
