<div class="card">
    <div class="card-header bg-php" id="player-badge-collapse-head" data-toggle="collapse" data-target="#player-badge-collapse" aria-expanded="true" aria-controls="player-badge-collapse">
        <h6 class="mb-0 font-weight-bold">
            ジムバッジ
        </h6>
    </div>
    <div id="player-badge-collapse" class="collapse" aria-labelledby="player-badge-collapse-head" data-parent="#player-modal-accordion">
        <div class="card-body">
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
