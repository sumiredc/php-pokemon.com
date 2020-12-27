<div class="modal fade" id="trainer-modal" tabindex="-1" role="dialog" aria-labelledby="trainer-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="trainer-modal-title">
                    <img src="/Assets/img/icon/battle.png" class="mr-2" alt="トレーナー戦" style="max-width: 24px;" />
                    トレーナー戦
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <form method="post" id="select-trainer-form">
                <div class="modal-body">
                    <figure class="text-center position-relative" style="height:120px;">
                        <img src="" id="select-trainer-image" class="center-image d-soft-none">
                    </figure>
                    <div class="mb-2 p-1 text-center small bg-light rounded-sm">
                        <p class="text-muted mb-0" data-trainer="default">トレーナーを選択してください</p>
                        <?php foreach(config('trainer') as $key => $trainer): ?>
                            <?php if(player()->isFightTrainer($key)): ?>
                                <p class="text-success d-soft-none mb-0" data-trainer="<?=$key?>">
                                    本日は残り<?=player()->getRemainingTrainerCount($key)?>回戦えます
                                </p>
                            <?php else: ?>
                                <p class="text-danger d-soft-none mb-0" data-trainer="<?=$key?>">
                                    本日はもう戦えません
                                </p>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="form-group">
                        <select class="form-control form-control-sm" name="trainer">
                            <option value="">-- 選択してください --</option>
                            <?php foreach(config('trainer') as $key => $trainer): ?>
                                <option value="<?=$key?>" data-img="<?=base64_storage('Trainers/'.$key.'.gif')?>"
                                    <?php if($trainer['level'] > player()->getLevel()): ?>
                                        data-fight="false" disabled
                                    <?php else: ?>
                                        data-fight="true"
                                    <?php endif;?>>
                                    <?=$trainer['name']?>（必要レベル：<?=$trainer['level']?>）
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <ul class="mb-0 pl-3 small">
                        <li class="text-muted">プレイヤーレベルが足りていないトレーナーとは戦えません</li>
                        <li class="text-muted">プレイヤーレベルは「メニュー」>「プレイヤー名」で確認できます</li>
                    </ul>
                </div><!-- Modal body -->
                <div class="modal-footer">
                    <input type="hidden" name="action" value="battle_trainer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">戻る</button>
                    <input class="btn btn-sm btn-php-dark" type="submit" value="戦う" disabled>
                    <?php input_token(); ?>
                </div>
            </form>
        </div><!-- Modal content -->
    </div><!-- Modal dialog -->
</div><!-- Modal  -->
