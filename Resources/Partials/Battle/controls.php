<section class="position-relative bg-php-back p-3" data-controls="message-box">
    <div class="row align-items-center">
        <div class="col-12 col-sm-6 mb-3 mb-sm-0">
            <div class="message-box border p-3">
                <?php # メッセージエリア ?>
                <?php foreach(response()->messages() as $key => list($msg, $status, $auto)): ?>
                    <?php $class = $key === response()->getMessageFirstKey() ? 'active' : ''; ?>
                    <?php $last_class = $key === response()->getMessageLastKey() ? 'last-message' : ''; ?>
                    <p class="result-message <?=$class?> <?=$last_class?> <?=$status ?? ''?>"
                        data-action='<?=response()->responses()[$status]['action'] ?? ''?>'
                        data-target='<?=response()->responses()[$status]['target'] ?? ''?>'
                        data-param='<?=response()->responses()[$status]['param'] ?? ''?>'
                        data-toggle='<?=response()->responses()[$status]['toggle'] ?? ''?>'
                        data-auto='<?=$auto ?? ''?>'>
                        <?=$msg?>
                    </p>
                <?php endforeach; ?>
                <i class="fas fa-hand-point-up fa-2x message-scroll-icon text-php-dark m-1"></i>
            </div>
        </div>
        <div class="col-12 col-sm-6">
            <div class="row">
                <div class="col-6 mb-2">
                    <?php if(friend()->checkUsedMove()): ?>
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
                    <button type="button" name="button" class="btn btn-disabled btn-block action-btn" data-submit_remote="run">逃げる</button>
                </div>
            </div>
        </div>
    </div>
</section>
