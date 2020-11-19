<!-- Modal -->
<div class="modal fade" id="party-modal" tabindex="-1" role="dialog" aria-labelledby="party-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="party-modal-title">
                    <img src="/Assets/img/icon/pokemon.png" alt="ポケモン" />
                    ポケモン
                 </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php foreach(player()->getParty() as $order => $party): ?>
                    <div class="row bg-hover-light" data-toggle="modal" data-dubble_modal="true" data-target="#pokemon<?=$order?>-details-modal">
                        <div class="col-3 text-center">
                            <img src="/Assets/img/pokemon/dots/mini/<?=get_class($party)?>.gif" alt="<?=$party->getName()?>">
                        </div>
                        <div class="col-9">
                            <div class="row">
                                <div class="col-12">
                                    <?=$party->getNickname()?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-10">
                                    <div class="progress" style="height:4px;">
                                        <div class="progress-bar bg-<?=$party->getRemainingHp('color')?>"
                                            role="progressbar"
                                            style="width:<?=$party->getRemainingHp('per')?>%;"
                                            aria-valuenow="<?=$party->getRemainingHp()?>"
                                            aria-valuemin="0"
                                            aria-valuemax="<?=$party->getStats('HP')?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    <?=$party->getRemainingHp()?> / <?=$party->getStats('HP')?>
                                </div>
                                <div class="col-4">
                                    Lv.<?=$party->getLevel()?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
