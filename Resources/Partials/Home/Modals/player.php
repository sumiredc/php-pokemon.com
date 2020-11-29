<!-- Modal -->
<div class="modal fade" id="player-modal" tabindex="-1" role="dialog" aria-labelledby="player-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="player-modal-title">
                    <img src="/Assets/img/player/red/mini/front.png" alt="<?=player()->getName()?>" />
                    <?=player()->getName()?>
                </h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <label class="font-weight-bold mb-0">おこづかい</label>：<?=player()->getMoney()?>円
                    </div>
                    <div class="col-6">
                        <label class="font-weight-bold mb-0">プレイヤーレベル</label>：<?=player()->getLevel()?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <?php foreach(config('gym') as $num => list($gym, $badge, $leader)): ?>
                        <div class="col-4 col-sm-3">
                            <h6>
                                <span class="badge badge-php-dark"><?=$num+1?></span>
                                <?=transJp($leader, 'trainer')?>
                            </h6>
                            <figure class="text-center">
                                <?php if(player()->isBadge($badge)): ?>
                                    <img src="/Assets/img/gym/badge/<?=$badge?>.png" alt="<?=$badge?>">
                                <?php else: ?>
                                    <img src="/Assets/img/gym/leader/thumb/<?=$leader?>.png" alt="<?=$leader?>">
                                <?php endif; ?>
                            </figure>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
