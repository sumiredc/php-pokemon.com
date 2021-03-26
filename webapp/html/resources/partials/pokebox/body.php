<?php # ボックス初期状態 ?>
<div class="col-12 bg-danger">
    <p class="text-white text-center mb-0 small">ボックス<?=pokebox()->getSelectedBoxNumber()?> 接続中...</p>
</div>
<div class="col-12 col-md-3 py-3 bg-light">
    <div class="overflow-auto" id="pokebox-tab-controls">
        <div class="nav flex-column nav-pills" id="pokebox-tab" role="tablist" aria-orientation="vertical" data-list="pokebox">
            <?php # 手持ち ?>
            <a class="nav-link d-flex justify-content-between btn-sm btn-secondary text-left m-1" id="pokebox-party-tab" href="#pokebox-party" role="tab" aria-controls="pokebox-party" aria-selected="true" data-toggle="pill" data-category="party">
                <span>手持ち</span>
                <span class="badge badge-light d-flex align-items-center"><?=count(player()->getParty())?></span>
            </a>
            <?php # ボックス ?>
            <?php foreach(pokebox()->getPokebox() as $num => $box): ?>
                <?php if(pokebox()->getSelectedBox() === $num): ?>
                    <?php # 起動中のボックス ?>
                    <a class="nav-link d-flex justify-content-between btn-sm btn-orange text-left m-1 active" id="pokebox-<?=$num?>-tab" href="#pokebox-<?=$num?>" role="tab" aria-controls="pokebox-<?=$num?>" aria-selected="true" data-toggle="pill" data-category="pokebox">
                        <span class="pokebox-name">ボックス<?=$num+1?><i class="fas fa-check-circle ml-2"></i></span>
                        <span class="badge badge-light d-flex align-items-center"><?=count($box)?></span>
                    </a>
                <?php else: ?>
                    <?php # 未接続のボックス ?>
                    <a class="nav-link d-flex justify-content-between btn-sm btn-secondary text-left m-1 cursor-pointer" data-toggle="modal" data-target="#pokebox-switch-modal" data-box="<?=$num?>">
                        <span class="pokebox-name">ボックス<?=$num+1?></span>
                        <span class="badge badge-light d-flex align-items-center"><?=count($box)?></span>
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<div class="col-12 col-md-9 py-3 theme-back">
    <div class="tab-content overflow-auto" id="pokebox-tab-content">
        <?php # 手持ち ?>
        <div class="tab-pane fade show" id="pokebox-party" role="tabpanel" aria-labelledby="pokebox-party-tab">
            <div class="row table-selected" data-list="pokemon">
                <?php foreach(player()->getParty() as $party): ?>
                    <figure class="col-6 col-sm-4 col-md-3 col-lg-2 d-flex">
                        <div class="d-flex w-100 flex-column justify-content-between table-selected-row bg-white rounded" data-place="party" data-pokemon_id="<?=$party->getId()?>">
                            <div class="p-1">
                                <p class="mb-0" id="pokebox-pokemon-name-<?=$party->getId()?>"><?=$party->getNickname()?></p>
                                <p>Lv.<?=$party->getLevel()?></p>
                            </div>
                            <div class="text-center mb-2">
                                <img id="pokebox-pokemon-img-<?=$party->getId()?>" src="<?=$party->base64()?>" alt="<?=$party::NAME?>">
                            </div>
                        </div>
                    </figure>
                <?php endforeach; ?>
            </div>
        </div>
        <?php # ボックス ?>
        <div class="tab-pane fade show active" id="pokebox-<?=pokebox()->getSelectedBox()?>" role="tabpanel" aria-labelledby="pokebox-<?=pokebox()->getSelectedBox()?>-tab">
            <div class="row table-selected" data-list="pokemon">
                <?php foreach(pokebox()->accessSelectedBox() as $pokemon): ?>
                    <figure class="col-6 col-sm-4 col-md-3 col-lg-2 d-flex">
                        <div class="d-flex w-100 flex-column justify-content-between table-selected-row bg-white rounded" data-place="pokebox" data-pokemon_id="<?=$pokemon->getId()?>">
                            <div class="p-1">
                                <p class="mb-0" id="pokebox-pokemon-name-<?=$pokemon->getId()?>"><?=$pokemon->getNickname()?></p>
                                <p>Lv.<?=$pokemon->getLevel()?></p>
                            </div>
                            <div class="text-center mb-2">
                                <img id="pokebox-pokemon-img-<?=$pokemon->getId()?>" src="<?=$pokemon->base64()?>" alt="<?=$pokemon::NAME?>">
                            </div>
                        </div>
                    </figure>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
