<!-- Modal -->
<div class="modal fade" id="item-use-friend-modal" tabindex="-1" role="dialog" aria-labelledby="item-use-friend-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <p class="small mb-0">
                    <span id="item-use-name" class="font-weight-bolder"></span>を使うポケモンを選んでください
                </p>
            </div>
            <div class="modal-body">
                <?php foreach(player()->getParty() as $order => $party): ?>
                    <div class="row bg-hover-light pokemon-row" data-pokemon="<?=$order?>">
                        <div class="col-3 text-center">
                            <img src="<?=$party->base64('mini')?>" alt="<?=$party::NAME?>">
                        </div>
                        <div class="col-9">
                            <div class="row">
                                <div class="col-12">
                                    <?=$party->getNickname()?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-10">
                                    <div class="progress rounded-pill bg-gray" style="height:4px;">
                                        <div class="progress-bar bg-<?=$party->getRemainingHp('color')?>"
                                            role="progressbar"
                                            style="width:<?=$party->getRemainingHp('per')?>%;"
                                            aria-valuenow="<?=$party->getRemainingHp()?>"
                                            aria-valuemin="0"
                                            aria-valuemax="<?=$party->getStats('H')?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    <?=$party->getRemainingHp()?> / <?=$party->getStats('H')?>
                                </div>
                                <div class="col-4">
                                    Lv.<?=$party->getLevel()?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="modal-footer">
                <form method="post" id="item-use-friend-form">
                    <?php input_token(); ?>
                    <input type="hidden" name="action" value="item">
                    <input type="hidden" name="do" value="use">
                    <input type="hidden" name="order"><?php # アイテム番号 ?>
                    <input type="hidden" name="pokemon"><?php # ポケモン番号 ?>
                </form>
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">やめる</button>
            </div>
        </div>
    </div>
</div>
