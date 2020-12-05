<?php
$pokemon = $controller->getPokemon();
?>
<!DOCTYPE html>
<html lang="jp" dir="ltr">
<head>
    <?php
    # metaの読み込み
    include(resources_path('Partials.Layouts.Head').'meta.php');
    # cssの読み込み
    include(resources_path('Partials.Layouts.Head').'css.php');
    ?>
    <link rel="stylesheet" href="/Assets/css/Page/evolve.css">
</head>
<body>
    <?php
    # headerの読み込み
    include(resources_path('Partials.Layouts.Head').'header.php');
    ?>
    <main>
        <div class="container-fluid bg-php-back section">
            <section>
                <div class="row">
                    <div class="col-12 text-center my-5">
                        <figure class="position-relative text-center d-inline-block area-evolve">
                            <img id="pokemon-before"
                            src="<?=$pokemon->base64()?>"
                            alt="<?=$pokemon::NAME?>"
                            class="bg-php-back p-5">
                            <?php if($pokemon::$after_class): ?>
                                <img id="pokemon-after"
                                src="<?=base64_pokemon($pokemon::$after_class)?>"
                                alt="進化先"
                                class="bg-php-back p-5">
                            <?php endif; ?>
                        </figure>
                    </div>
                </div>
            </section>
            <section class="p-3">
                <div class="row">
                    <div class="col-12">
                        <div class="message-box border p-3" data-controls="message-box">
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
                            <button type="button" id="cancel-evolve" class="btn btn-sm btn-danger d-soft-none">進化させない</button>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <?php
    # footerの読み込み
    include(resources_path('Partials.Layouts.Foot').'footer.php');
    # モーダルの読み込み
    foreach(response()->modals() as $modal){
        include(resources_path('Partials.Evolve.Modals').$modal['modal'].'.php');
    }
    # JSの読み込み
    include(resources_path('Partials.Layouts.Foot').'js.php');
    ?>
    <script src="/Assets/js/Common/forget-move.js" type="text/javascript" defer></script>
    <script src="/Assets/js/Common/action-message.js" type="text/javascript" defer></script>
    <script src="/Assets/js/Evolve/library-evolve.js" type="text/javascript" defer></script>
</body>
</html>
