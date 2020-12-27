<!-- Modal -->
<div class="modal fade" id="player-modal" tabindex="-1" role="dialog" aria-labelledby="player-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="player-modal-title">
                    <img src="/Assets/img/player/red/mini/front.png" alt="<?=player()->getName()?>" />
                    <?=player()->getName()?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="font-weight-bold mb-0">プレイヤーID</label>
                            <p class="form-control-plaintext bg-light rounded-sm py-1 px-2 cursor-pointer" data-clipboard="true" title="クリックでコピーします"><?=player()->getID()?></p>
                            <small class="form-text text-muted ml-2">クリックでコピーします</small>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label class="font-weight-bold mb-0">おこづかい</label>
                            <p class="form-control-plaintext bg-light rounded-sm py-1 px-2"><?=player()->getMoney()?>円</p>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label class="font-weight-bold mb-0">プレイヤーレベル</label>
                            <p class="form-control-plaintext bg-light rounded-sm py-1 px-2"><?=player()->getLevel()?></p>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <?php foreach(config('gym') as $num => $gym): ?>
                        <div class="col-4 col-sm-3">
                            <h6>
                                <span class="badge badge-php-dark"><?=$num+1?></span>
                                <?=transJp($gym::LEADER, 'leader')?>
                            </h6>
                            <figure class="text-center">
                                <?php if(player()->isBadge($gym::BADGE)): ?>
                                    <img src="<?=$gym::base64Badge()?>" alt="<?=$gym::BADGE?>">
                                <?php else: ?>
                                    <img src="<?=$gym::base64Leader('thumb')?>" alt="<?=$gym::LEADER?>">
                                <?php endif; ?>
                            </figure>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
