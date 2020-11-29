<?php foreach([friend(), enemy()] as $battle_state_pokemon): ?>
    <?php $id = $battle_state_pokemon->getPosition().'-battle-state'; ?>
    <!-- Modal -->
    <div class="modal fade" id="<?=$id?>-modal" tabindex="-1" role="dialog" aria-labelledby="<?=$id?>-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="<?=$id?>-modal-title"><?=transJp($battle_state_pokemon->getPosition())?>の状態</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body overflow-auto my-2" style="height:360px;">
                    <nav class="nav nav-pills nav-justified btn-group mb-3" id="<?=$id?>-tab">
                        <a class="btn btn-outline-php-dark nav-item nav-link active"
                        id="<?=$id?>-rank-tab"
                        data-toggle="tab"
                        href="#<?=$id?>-rank"
                        role="tab"
                        aria-controls="<?=$id?>-rank"
                        aria-selected="true">ランク補正</a>
                        <a class="btn btn-outline-php-dark nav-item nav-link"
                        id="<?=$id?>-sc-tab"
                        data-toggle="tab"
                        href="#<?=$id?>-sc"
                        role="tab"
                        aria-controls="<?=$id?>-sc"
                        aria-selected="true">状態変化</a>
                        <a class="btn btn-outline-php-dark nav-item nav-link"
                        id="<?=$id?>-field-tab"
                        data-toggle="tab"
                        href="#<?=$id?>-field"
                        role="tab"
                        aria-controls="<?=$id?>-field"
                        aria-selected="true">フィールド</a>
                    </nav>
                    <div class="tab-content" id="<?=$id?>-tab-content">
                        <div class="tab-pane fade show active" id="<?=$id?>-rank" role="tabpanel" aria-labelledby="<?=$id?>-rank-tab">
                            <?php # ランク補正 ?>
                            <div class="p-2 bg-light">
                                <table class="table table-sm mb-0">
                                    <tbody class="first-border-top-none">
                                        <?php foreach($battle_state_pokemon->getRank() as $label => $rank): ?>
                                            <tr>
                                                <th width="20%"><?=transJp($label, 'stats')?></th>
                                                <td width="20%">
                                                    <?php if($rank < 0): ?>
                                                        <span class="text-primary"><?=$rank?></span>
                                                    <?php elseif($rank > 0): ?>
                                                        <span class="text-danger"><?=$rank?></span>
                                                    <?php endif; ?>
                                                </td>
                                                <?php
                                                if($rank < 0){
                                                    $rank *= -1;
                                                    $icon = '<i class="fas fa-caret-right rank-negative text-primary"></i>';
                                                }else{
                                                    $icon = '<i class="fas fa-caret-right rank-active text-danger"></i>';
                                                }
                                                ?>
                                                <?php for($i=0; $i < 6; $i++):?>
                                                    <td width="10%" class="h4"><?php if($i < $rank) echo $icon; ?></td>
                                                <?php endfor; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="<?=$id?>-sc" role="tabpanel" aria-labelledby="<?=$id?>-sc-tab">
                            <?php # 状態変化 ?>
                            <div class="row">
                                <?php foreach($battle_state_pokemon->getScObject() as $sc): ?>
                                    <div class="col-6">
                                        <div class="alert alert-php-info" role="alert">
                                            <h6 class="alert-heading mb-0"><?=$sc->getName()?>状態</h6>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="<?=$id?>-field" role="tabpanel" aria-labelledby="<?=$id?>-field-tab">
                            <?php # フィールド ?>
                            <div class="row">
                                <?php foreach(battle_state()->getField($battle_state_pokemon->getPosition(), true) as list($field, $turn)): ?>
                                    <div class="col-6">
                                        <div class="alert alert-cyan" role="alert">
                                            <h6 class="alert-heading"><?=$field->getName()?></h6>
                                            <p class="font-weight-bolder mb-0">残り<?=$turn?>ターン</p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
