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
                        <?php foreach($pokemon->getMove() as $key => $move): ?>
                            <tr class="move-detail-link forget-selectmove <?php if($key === 4) echo 'active new-move'; ?>"
                                data-modal="#<?=$modal['id']?>-modal"
                                data-target="#<?=$modal['id']?>_<?=get_class($move['class'])?>-content"
                                data-name="<?=$move['class']->getName()?>"
                                data-num="<?=$key?>">
                                <th scope="row" class="w-50"><?=$move['class']->getName()?></th>
                                <td><?=$move['class']->getType()->getName()?></td>
                                <td><?=$move['remaining']?>/<?=$move['class']->getPp($move['correction'])?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php # 覚えようとしている技 ?>
                        <tr class="move-detail-link forget-selectmove active new-move"
                            data-modal="#<?=$modal['id']?>-modal"
                            data-target="#<?=$modal['id']?>_<?=get_class($modal['new_move'])?>-content"
                            data-name="<?=$modal['new_move']->getName()?>"
                            data-num="<?=$key?>">
                            <th scope="row" class="w-50"><?=$modal['new_move']->getName()?></th>
                            <td><?=$modal['new_move']->getType()->getName()?></td>
                            <td><?=$modal['new_move']->getPp()?>/<?=$modal['new_move']->getPp()?></td>
                        </tr>
                    </tbody>
                </table>
                <?php # 技説明 ?>
                <div class="overflow-auto p-3 border" style="height:160px;">
                    <?php foreach($pokemon->getMove() as $key => $move): ?>
                        <div class="move-detail-content" id="<?=$modal['id']?>_<?=get_class($move['class'])?>-content">
                            <h6><?=$move['class']->getName()?></h6>
                            <hr>
                            <p><?=$move['class']->getDescription()?></p>
                        </div>
                    <?php endforeach; ?>
                    <?php # 覚えようとしている技 ?>
                    <div class="move-detail-content active" id="<?=$modal['id']?>_<?=get_class($modal['new_move'])?>-content">
                        <h6><?=$modal['new_move']->getName()?></h6>
                        <hr>
                        <p><?=$modal['new_move']->getDescription()?></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?php # 忘れさせるボタン ?>
                <button type="button"
                class="btn btn-danger btn-sm btn-forget-move"
                data-modal="#<?=$modal['id']?>-modal"
                data-msg_id="<?=$modal['id']?>"
                style="display:none;">
                <span class="move-name"></span>を忘れる</button>
                <?php # 諦めるボタン ?>
                <button type="button"
                class="btn btn-secondary btn-sm action-message-box btn-abandon-move"
                data-dismiss="modal">
                <?=$modal['new_move']->getName()?>を諦める</button>
            </div>
        </div>
    </div>
</div>
