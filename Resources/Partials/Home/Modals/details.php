<!-- Modal -->
<div class="modal fade" id="pokemon-details-modal" tabindex="-1" role="dialog" aria-labelledby="pokemon-details-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pokemon-details-modal-title">ポケモン詳細</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body overflow-auto my-2" style="height:450px;">
                <div class="row my-3">
                    <div class="col-5 offset-1 text-center">
                        <img src="/Assets/img/pokemon/dots/front/<?=get_class($pokemon)?>.gif" alt="<?=$pokemon->getName()?> 前">
                    </div>
                    <div class="col-5 text-center">
                        <img src="/Assets/img/pokemon/dots/back/<?=get_class($pokemon)?>.gif" alt="<?=$pokemon->getName()?> 後">
                    </div>
                </div>
                <nav class="nav nav-pills nav-justified btn-group mb-3" id="pokemon-details-tab">
                    <a class="btn btn-outline-secondary nav-item nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">詳細</a>
                    <a class="btn btn-outline-secondary nav-item nav-link" id="stats-tab" data-toggle="tab" href="#stats" role="tab" aria-controls="stats" aria-selected="true">ステータス</a>
                    <a class="btn btn-outline-secondary nav-item nav-link" id="move-tab" data-toggle="tab" href="#move" role="tab" aria-controls="move" aria-selected="true">使える技</a>
                </nav>
                <div class="tab-content" id="pokemon-details-tabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
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
                    <div class="tab-pane fade show" id="stats" role="tabpanel" aria-labelledby="stats-tab">
                        <?php # ステータス ?>
                        <table class="table table-bordered table-sm table-hover">
                            <tbody>
                                <?php foreach($pokemon->getStats() as $key => $val): ?>
                                    <tr>
                                        <th scope="row" class="w-50"><?=transJp($key)?></th>
                                        <td><?=$val?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade show" id="move" role="tabpanel" aria-labelledby="move-tab">
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
                                <?php foreach($pokemon->getMove() as $move): ?>
                                    <tr class="move-detail-link" data-target="#move_<?=get_class($move['class'])?>-content">
                                        <th scope="row" class="w-50"><?=$move['class']->getName()?></th>
                                        <td><?=$move['class']->getType()->getName()?></td>
                                        <td><?=$move['remaining']?>/<?=$move['class']->getPp($move['correction'])?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php # 技説明 ?>
                        <div class="overflow-auto p-3 border" style="height:160px;">
                            <?php foreach($pokemon->getMove() as $key => $move): ?>
                                <div class="move-detail-content <?php if(array_key_first($pokemon->getMove()) == $key) echo 'active'; ?>" id="move_<?=get_class($move['class'])?>-content">
                                    <h6><?=$move['class']->getName()?></h6>
                                    <hr>
                                    <p><?=$move['class']->getDescription()?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
