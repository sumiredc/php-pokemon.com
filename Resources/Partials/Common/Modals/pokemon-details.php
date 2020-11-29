<!-- Modal -->
<div class="modal fade" id="pokemon<?=$pokemon->getId()?>-details-modal" tabindex="-1" role="dialog" aria-labelledby="pokemon<?=$pokemon->getId()?>-details-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pokemon<?=$pokemon->getId()?>-details-modal-title">
                    <img src="/Assets/img/pokemon/dots/mini/<?=get_class($pokemon)?>.gif" alt="<?=$pokemon->getName()?>_ミニ">
                    <?=$pokemon->getNickname()?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body overflow-auto my-2" style="height:450px;">
                <div class="theme-back mb-3 p-3 rounded">
                    <figure class="d-flex justify-content-around align-items-center mb-0" style="min-height:80px;">
                        <img src="/Assets/img/pokemon/dots/front/<?=get_class($pokemon)?>.gif" alt="<?=$pokemon->getName()?>_前">
                        <img src="/Assets/img/pokemon/dots/back/<?=get_class($pokemon)?>.gif" alt="<?=$pokemon->getName()?>_後">
                    </figure>
                </div>
                <nav class="nav nav-pills nav-justified btn-group mb-3" id="pokemon<?=$pokemon->getId()?>-details-tab">
                    <a class="btn btn-outline-php-dark nav-item nav-link active" id="pokemon<?=$pokemon->getId()?>-details-home-tab" data-toggle="tab" href="#pokemon<?=$pokemon->getId()?>-details-home" role="tab" aria-controls="pokemon<?=$pokemon->getId()?>-details-home" aria-selected="true">詳細</a>
                    <a class="btn btn-outline-php-dark nav-item nav-link" id="pokemon<?=$pokemon->getId()?>-details-stats-tab" data-toggle="tab" href="#pokemon<?=$pokemon->getId()?>-details-stats" role="tab" aria-controls="pokemon<?=$pokemon->getId()?>-details-stats" aria-selected="true">ステータス</a>
                    <a class="btn btn-outline-php-dark nav-item nav-link" id="pokemon<?=$pokemon->getId()?>-details-move-tab" data-toggle="tab" href="#pokemon<?=$pokemon->getId()?>-details-move" role="tab" aria-controls="pokemon<?=$pokemon->getId()?>-details-move" aria-selected="true">使える技</a>
                </nav>
                <div class="tab-content" id="pokemon<?=$pokemon->getId()?>-details-tab-content">
                    <div class="tab-pane fade show active" id="pokemon<?=$pokemon->getId()?>-details-home" role="tabpanel" aria-labelledby="pokemon<?=$pokemon->getId()?>-details-tab-home">
                        <?php # 詳細 ?>
                        <table class="table table-bordered table-sm table-hover">
                            <tbody>
                                <?php foreach($pokemon->getDetails() as $key => $val): ?>
                                    <tr>
                                        <th scope="row" class="w-50"><?=transJp($key)?></th>
                                        <td><?=$val?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade show" id="pokemon<?=$pokemon->getId()?>-details-stats" role="tabpanel" aria-labelledby="pokemon<?=$pokemon->getId()?>-details-tab-stats">
                        <?php # ステータス ?>
                        <table class="table table-bordered table-sm table-hover">
                            <tbody>
                                <?php foreach($pokemon->getStats() as $key => $val): ?>
                                    <tr>
                                        <th scope="row" class="w-50"><?=transJp($key, 'stats')?></th>
                                        <td><?=$val?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade show" id="pokemon<?=$pokemon->getId()?>-details-move" role="tabpanel" aria-labelledby="pokemon<?=$pokemon->getId()?>-details-tab-move">
                        <?php # 覚えている技 ?>
                        <table class="table table-bordered table-selected table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">覚えている技</th>
                                    <th scope="col">タイプ</th>
                                    <th scope="col">PP</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($pokemon->getMove() as $move): ?>
                                    <tr class="move-detail-link" data-target="#pokemon<?=$pokemon->getId()?>-move_<?=get_class($move['class'])?>-content">
                                        <th scope="row" class="w-50"><?=$move['class']->getName()?></th>
                                        <td><?=$move['class']->getType()->getName()?></td>
                                        <td><?=$move['remaining']?>/<?=$move['class']->getPp($move['correction'])?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php # 技説明 ?>
                        <div class="overflow-auto p-3 border" style="height:120px;">
                            <?php foreach($pokemon->getMove() as $move): ?>
                                <div class="move-detail-content" id="pokemon<?=$pokemon->getId()?>-move_<?=get_class($move['class'])?>-content">
                                    <div class="row">
                                        <div class="col-4">
                                            <label class="font-weight-bold mb-0">命中</label>：<?=$move['class']->getAccuracy() ?? '-'?>
                                        </div>
                                        <div class="col-4">
                                            <label class="font-weight-bold mb-0">威力</label>：<?=$move['class']->getPower() ?? '-'?>
                                        </div>
                                        <div class="col-4">
                                            <label class="font-weight-bold mb-0">分類</label>：<?=transJp($move['class']->getSpecies(), 'move')?>
                                        </div>
                                    </div>
                                    <hr>
                                    <p class="mb-0"><?=$move['class']->getDescription()?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
