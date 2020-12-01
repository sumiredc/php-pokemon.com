<?php
$root_path = __DIR__.'/../..';
$pokemon = $controller->getPokemon();
?>
<!DOCTYPE html>
<html lang="jp" dir="ltr">
<head>
    <?php
    # metaの読み込み
    include($root_path.'/Resources/Partials/Layouts/Head/meta.php');
    # cssの読み込み
    include($root_path.'/Resources/Partials/Layouts/Head/css.php');
    ?>
</head>
<body>
    <?php
    # headerの読み込み
    include($root_path.'/Resources/Partials/Layouts/Head/header.php');
    ?>
    <main>
        <div class="container-fluid bg-php-back section">
            <section>
                <div class="row">
                    <div class="col-12 text-center my-5">
                        <figure class="position-relative text-center d-inline-block area-evolve">
                            <img
                            src="/Assets/img/pokemon/dots/front/<?=get_class($pokemon)?>.gif"
                            alt="<?=$pokemon->getName()?>"
                            class="bg-php-back p-5"
                            >
                            <?php if($pokemon->getAfterClass()): ?>
                                <img
                                id="pokemon-after"
                                src="/Assets/img/pokemon/dots/front/<?=$pokemon->getAfterClass()?>.gif"
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
                            <button type="button" id="cancel-evolve" class="btn btn-sm btn-danger" style="display:none;">進化させない</button>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <?php
    # footerの読み込み
    include($root_path.'/Resources/Partials/Layouts/Foot/footer.php');
    # モーダルの読み込み
    foreach(response()->modals() as $modal){
        include($root_path.'/Resources/Partials/Evolve/Modals/'.$modal['modal'].'.php');
    }
    # JSの読み込み
    include($root_path.'/Resources/Partials/Layouts/Foot/js.php');
    ?>
    <script src="/Assets/js/Common/forget-move.js" type="text/javascript" defer></script>
    <script src="/Assets/js/Common/action-message.js" type="text/javascript" defer></script>
    <script src="/Assets/js/Evolve/library-evolve.js" type="text/javascript" defer></script>
</body>
</html>
