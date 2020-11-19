<!-- Modal -->
<div class="modal fade" id="pokemon<?=$order?>-details-modal" tabindex="-1" role="dialog" aria-labelledby="pokemon<?=$order?>-details-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pokemon<?=$order?>-details-modal-title">ポケモン詳細</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body overflow-auto my-2" style="height:450px;">
                <div class="row my-3">
                    <div class="col-5 offset-1 text-center">
                        <img src="/Assets/img/pokemon/dots/front/<?=get_class($party)?>.gif" alt="<?=$party->getName()?>_前">
                    </div>
                    <div class="col-5 text-center">
                        <img src="/Assets/img/pokemon/dots/back/<?=get_class($party)?>.gif" alt="<?=$party->getName()?>_後">
                    </div>
                </div>
                <nav class="nav nav-pills nav-justified btn-group mb-3" id="pokemon<?=$order?>-details-tab">
                    <a class="btn btn-outline-secondary nav-item nav-link active" id="pokemon<?=$order?>-details-home-tab" data-toggle="tab" href="#pokemon<?=$order?>-details-home" role="tab" aria-controls="pokemon<?=$order?>-details-home" aria-selected="true">詳細</a>
                    <a class="btn btn-outline-secondary nav-item nav-link" id="pokemon<?=$order?>-details-stats-tab" data-toggle="tab" href="#pokemon<?=$order?>-details-stats" role="tab" aria-controls="pokemon<?=$order?>-details-stats" aria-selected="true">ステータス</a>
                    <a class="btn btn-outline-secondary nav-item nav-link" id="pokemon<?=$order?>-details-move-tab" data-toggle="tab" href="#pokemon<?=$order?>-details-move" role="tab" aria-controls="pokemon<?=$order?>-details-move" aria-selected="true">使える技</a>
                </nav>
                <div class="tab-content" id="pokemon<?=$order?>-details-tab-content">
                    <div class="tab-pane fade show active" id="pokemon<?=$order?>-details-home" role="tabpanel" aria-labelledby="pokemon<?=$order?>-details-tab-home">
                        <?php # 詳細 ?>
                        <table class="table table-bordered table-sm table-hover">
                            <tbody>
                                <?php foreach($party->getDetails() as $key => $val): ?>
                                    <tr>
                                        <th scope="row" class="w-50"><?=transJp($key)?></th>
                                        <td><?=$val?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade show" id="pokemon<?=$order?>-details-stats" role="tabpanel" aria-labelledby="pokemon<?=$order?>-details-tab-stats">
                        <?php # ステータス ?>
                        <table class="table table-bordered table-sm table-hover">
                            <tbody>
                                <?php foreach($party->getStats() as $key => $val): ?>
                                    <tr>
                                        <th scope="row" class="w-50"><?=transJp($key, 'stats')?></th>
                                        <td><?=$val?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade show" id="pokemon<?=$order?>-details-move" role="tabpanel" aria-labelledby="pokemon<?=$order?>-details-tab-move">
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
                                <?php foreach($party->getMove() as $move): ?>
                                    <tr class="move-detail-link" data-target="#pokemon<?=$order?>-move_<?=get_class($move['class'])?>-content">
                                        <th scope="row" class="w-50"><?=$move['class']->getName()?></th>
                                        <td><?=$move['class']->getType()->getName()?></td>
                                        <td><?=$move['remaining']?>/<?=$move['class']->getPp($move['correction'])?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php # 技説明 ?>
                        <div class="overflow-auto p-3 border" style="height:120px;">
                            <?php foreach($party->getMove() as $move): ?>
                                <div class="move-detail-content" id="pokemon<?=$order?>-move_<?=get_class($move['class'])?>-content">
                                    <h6><?=$move['class']->getName()?></h6>
                                    <hr>
                                    <p class="mb-0 small"><?=$move['class']->getDescription()?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
