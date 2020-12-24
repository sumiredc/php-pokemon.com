<div class="modal fade" id="select-move-modal" tabindex="-1" role="dialog" aria-labelledby="select-move-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="select-move-modal-title">たたかう</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="fight-form">
                    <input type="hidden" name="action" value="fight">
                    <input type="hidden" name="param" id="fight-form-param">
                    <div class="input-group">
                        <table class="table table-bordered table-hover table-sm mb-0" id="move-table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" style="width:40%">使える技</th>
                                    <th scope="col" style="width:25%">タイプ</th>
                                    <th scope="col" style="width:25%">PP</th>
                                    <th scope="col" style="width:10%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach(friend()->getBattleMove() as $key => $move): ?>
                                    <?php if(empty($move['remaining']) || $move['class'] === friend()->getScOther('ScDisable')): ?>
                                        <tr class="bg-light text-secondary"
                                        style="cursor:not-allowed;">
                                    <?php else: ?>
                                        <tr class="move-table-row" data-key="<?=$key?>">
                                        <?php endif; ?>
                                        <th scope="row" data-move="name"><?=$move['class']::NAME?></th>
                                        <td data-move="type"><?=$move['class']::getTypeName()?></td>
                                        <td data-move="pp">
                                            <?php if(empty($move['remaining'])):?>
                                                <span class="text-danger"><?=$move['remaining']?></span>
                                            <?php else: ?>
                                                <?=$move['remaining']?>
                                            <?php endif; ?>
                                            /<?=$move['class']::getPp($move['correction'])?>
                                        </td>
                                        <td tabIndex="0"
                                        class="text-center"
                                        data-move="details"
                                        data-toggle="popover"
                                        data-trigger="focus"
                                        data-html="true"
                                        data-content="<?=$move['class']::DESCRIPTION?>"
                                        title='<small>
                                            命中：<?=$move['class']::ACCURACY ?? '-'?>　
                                            威力：<?=$move['class']::POWER ?? '-'?>　
                                            分類：<?=transJp($move['class']::SPECIES, 'move')?>
                                        </small>'><i class="fas fa-info-circle text-php-dark"></i></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php if(friend()->isSc('ScDisable')): ?>
                            <p class="text-danger small mt-2">「<?=constant(friend()->getScOther('ScDisable').'::NAME')?>」は、かなしばり状態のため使えません</p>
                        <?php endif; ?>
                    </div>
                    <?php input_token(); ?>
                </form>
            </div>
        </div>
    </div>
</div>
