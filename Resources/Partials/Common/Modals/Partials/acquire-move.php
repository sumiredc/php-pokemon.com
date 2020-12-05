<!-- Modal -->
<?php $pokemon = player()->getPartner($modal['pokemon_id'], 'id'); ?>
<div class="modal fade" id="<?=$modal['id']?>-modal" tabindex="-1" role="dialog" aria-labelledby="<?=$modal['id']?>-modal-title" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="<?=$modal['id']?>-modal-title">
                    <img src="/Assets/img/pokemon/dots/mini/<?=get_class($pokemon)?>.gif" alt="<?=$pokemon::NAME?>">
                    <?=$pokemon->getNickname()?>
                </h5>
            </div>
            <div class="modal-body">
                <?php # 覚えている技 ?>
                <table class="table table-bordered table-selected table-sm table-hover">
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
                                data-target="#<?=$modal['id']?>_<?=$move['class']?>-content"
                                data-name="<?=$move['class']::NAME?>"
                                data-num="<?=$key?>">
                                <th scope="row" class="w-50"><?=$move['class']::NAME?></th>
                                <td><?=$move['class']::getTypeName()?></td>
                                <td><?=$move['remaining']?>/<?=$move['class']::getPp($move['correction'])?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php # 覚えようとしている技 ?>
                        <tr class="move-detail-link forget-selectmove active new-move"
                            data-modal="#<?=$modal['id']?>-modal"
                            data-target="#<?=$modal['id']?>_<?=$modal['new_move']?>-content"
                            data-name="<?=$modal['new_move']::NAME?>"
                            data-num="<?=++$key?>">
                            <th scope="row" class="w-50"><?=$modal['new_move']::NAME?></th>
                            <td><?=$modal['new_move']::getTypeName()?></td>
                            <td><?=$modal['new_move']::PP?>/<?=$modal['new_move']::PP?></td>
                        </tr>
                    </tbody>
                </table>
                <?php # 技説明 ?>
                <div class="overflow-auto p-3 border" style="height:120px;">
                    <?php foreach($pokemon->getMove() as $key => $move): ?>
                        <div class="move-detail-content" id="<?=$modal['id']?>_<?=$move['class']?>-content">
                            <h6 class="font-weight-bolder"><?=$move['class']::NAME?></h6>
                            <hr>
                            <p class="mb-0 small"><?=$move['class']::DESCRIPTION?></p>
                        </div>
                    <?php endforeach; ?>
                    <?php # 覚えようとしている技 ?>
                    <div class="move-detail-content active" id="<?=$modal['id']?>_<?=get_class($modal['new_move'])?>-content">
                        <h6><?=$modal['new_move']::NAME?></h6>
                        <hr>
                        <p><?=$modal['new_move']::DESCRIPTION?></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?php # 忘れさせるボタン ?>
                <button type="button" class="btn btn-php-dark btn-sm btn-forget-move" data-modal="#<?=$modal['id']?>-modal" data-msg_id="<?=$modal['id']?>"
                style="display:none;">
                <span class="move-name"></span>を忘れる</button>
                <?php # 諦めるボタン ?>
                <button type="button" class="btn btn-secondary btn-sm btn-abandon-move" data-dismiss="modal" data-controls="message-box">
                <?=$modal['new_move']::NAME?>を諦める</button>
            </div>
        </div>
    </div>
</div>
