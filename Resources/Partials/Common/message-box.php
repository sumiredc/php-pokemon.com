<?php # data-controlsはバトル画面で不要 ?>
<div class="message-box border p-3" <?php if(getPageName() !== 'battle'): ?> data-controls="message-box" <?php endif; ?>>
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
    <?php if(getPageName() === 'evolve'): ?>
        <button type="button" id="cancel-evolve" class="btn btn-sm btn-danger d-soft-none">
            進化させない
        </button>
    <?php endif; ?>
</div>
