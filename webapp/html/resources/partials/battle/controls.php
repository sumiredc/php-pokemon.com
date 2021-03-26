<section class="position-relative bg-php-back p-3" data-controls="message-box">
    <div class="row align-items-center">
        <div class="col-12 col-sm-6 mb-3 mb-sm-0">
            <?php
            # メッセージボックス
            include resources_path('partials/common/message-box.php');
            ?>
            </div>
            <div class="col-12 col-sm-6">
                <div class="row">
                    <div class="col-6 mb-2">
                        <?php if(friend()->isUsedMove()): ?>
                            <button type="button"
                            class="btn btn-disabled btn-block action-btn"
                            data-toggle="modal"
                            data-target="#select-move-modal"
                            id="action-btn-fight">たたかう
                        </button>
                    <?php else: ?>
                        <form method="post">
                            <input type="hidden" name="action" value="fight">
                            <input type="submit" class="btn btn-disabled btn-block action-btn" value="たたかう">
                            <?php input_token(); ?>
                        </form>
                    <?php endif; ?>
                </div>
                <div class="col-6 mb-2">
                    <button type="button" class="btn btn-disabled btn-block action-btn" data-toggle="modal" data-target="#item-modal" id="action-btn-item">どうぐ</button>
                </div>
                <div class="col-6">
                    <button type="button" class="btn btn-disabled btn-block action-btn" data-toggle="modal" data-target="#party-modal">ポケモン</button>
                </div>
                <div class="col-6">
                    <?php if(battle_state()->isMode('trainer')): ?>
                        <button type="button" name="button" class="btn btn-disabled btn-block action-btn" data-toggle="modal" data-target="#surrender-modal">降参</button>
                    <?php else: ?>
                        <button type="button" name="button" class="btn btn-disabled btn-block action-btn" data-submit_remote="run">逃げる</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
