<div class="modal fade" id="gym-modal" tabindex="-1" role="dialog" aria-labelledby="gym-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gym-modal-title">
                    <img src="/assets/img/icon/battle.png" class="mr-2" alt="ジム戦" style="max-width: 24px;" />
                    ジム
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="select-gym-form">
                <div class="modal-body">
                    <figure class="text-center position-relative" style="height:70px;">
                        <img src="" id="select-gym-image" class="center-image d-soft-none">
                    </figure>
                    <div class="mb-2 p-1 text-center small bg-light rounded-sm">
                        <p class="text-muted mb-0" data-gym="default">
                            ジムを選択してください
                        </p>
                        <?php foreach(config('gym') as $num => $gym): ?>
                            <?php if(!$gym::isRequiredChallenge(player())): ?>
                                <p class="text-danger d-soft-none mb-1" data-gym="<?=$num?>">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>必要条件を満たせていません
                                </p>
                            <?php endif; ?>
                            <ol class="mb-0 pl-4 small text-left d-soft-none" data-gym="<?=$num?>">
                                <?php foreach($gym::REQUIRED_CHALLENGE as $text): ?>
                                    <li class="text-muted"><?=$text?></li>
                                <?php endforeach; ?>
                            </ol>
                        <?php endforeach; ?>
                    </div>
                    <div class="form-group">
                        <select class="form-control form-control-sm" name="gym">
                            <option value="">-- 選択してください --</option>
                            <?php foreach(config('gym') as $num => $gym): ?>
                                <option value="<?=$num?>" data-img="<?=$gym::base64Leader('thumb')?>"
                                    <?php if($gym::isRequiredChallenge(player()) && !player()->isBadge($gym::BADGE)): ?>
                                        data-fight="true"
                                    <?php else: ?>
                                        data-fight="false"
                                    <?php endif; ?>>
                                    <?=$gym::NAME?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <ul class="mb-0 pl-3 small">
                        <li class="text-muted">ジムへ挑むには必要条件を満たす必要があります</li>
                    </ul>
                </div><!-- Modal body -->
                <div class="modal-footer">
                    <input type="hidden" name="action" value="battle_leader">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">戻る</button>
                    <input class="btn btn-sm btn-php-dark" type="submit" value="ジム戦に挑む" disabled>
                    <?php input_token(); ?>
                </div>
            </form>
        </div><!-- Modal content -->
    </div><!-- Modal dialog -->
</div><!-- Modal  -->
