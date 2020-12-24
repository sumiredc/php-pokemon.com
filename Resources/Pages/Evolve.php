<?php
$pokemon = $controller->getPokemon();
?>
<!DOCTYPE html>
<html lang="jp" dir="ltr">
<head>
    <?php
    # metaの読み込み
    include(resources_path('Partials/Layouts/Head').'meta.php');
    # cssの読み込み
    include(resources_path('Partials/Layouts/Head').'css.php');
    ?>
    <link rel="stylesheet" href="/Assets/css/Page/evolve.css">
</head>
<body>
    <?php
    # headerの読み込み
    include(resources_path('Partials/Layouts/Head').'header.php');
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
                            class="bg-php-back p-5" />
                            <?php if($pokemon->getAfterClass()): ?>
                                <img id="pokemon-after"
                                src="<?=base64_pokemon($pokemon->getAfterClass())?>"
                                alt="進化先"
                                class="bg-php-back p-5" />
                            <?php endif; ?>
                        </figure>
                    </div>
                </div>
            </section>
            <section class="p-3">
                <div class="row">
                    <div class="col-12">
                        <?php
                        # メッセージボックス
                        include(resources_path('Partials/Common').'message-box.php');
                        ?>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <?php
    # footerの読み込み
    include(resources_path('Partials/Layouts/Foot').'footer.php');
    # モーダルの読み込み
    foreach(response()->modals() as $modal){
        include(resources_path('Partials/Evolve/Modals').$modal['modal'].'.php');
    }
    # JSの読み込み
    include(resources_path('Partials/Layouts/Foot').'js.php');
    ?>
    <script src="/Assets/js/Common/forget-move.js" type="text/javascript" defer></script>
    <script src="/Assets/js/Common/action-message.js" type="text/javascript" defer></script>
    <script src="/Assets/js/Evolve/library-evolve.js" type="text/javascript" defer></script>
</body>
</html>
