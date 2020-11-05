<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Resources/Partials/Layouts/Head/evolve.php');
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
        <div class="container">
            <section>
                <div class="row">
                    <div class="col-12 text-center mb-5">
                        <figure class="position-relative text-center d-inline-block area-evolve">
                            <img
                            src="/Assets/img/pokemon/dots/front/<?=get_class($pokemon)?>.gif"
                            alt="<?=$pokemon->getName()?>"
                            class="bg-white p-5"
                            >
                            <?php if($pokemon->getAfterClass()): ?>
                                <img
                                id="pokemon-after"
                                src="/Assets/img/pokemon/dots/front/<?=$pokemon->getAfterClass()?>.gif"
                                alt="進化先"
                                class="bg-white p-5">
                            <?php endif; ?>
                        </figure>
                    </div>
                </div>
            </section>
            <section class="bg-light p-3">
                <div class="row">
                    <div class="col-12">
                        <div class="message-box action-message-box border p-3">
                            <?php # メッセージエリア ?>
                            <?php foreach($messages as $key => list($msg, $status, $auto)): ?>
                                <?php $class = $key === $global_responses->getMessageFirstKey() ? 'active' : ''; ?>
                                <?php $last_class = $key === $global_responses->getMessageLastKey() ? 'last-message' : ''; ?>
                                <p class="result-message <?=$class?> <?=$last_class?> <?=$status ?? ''?>"
                                    data-action='<?=$responses[$status]['action'] ?? ''?>'
                                    data-target='<?=$responses[$status]['target'] ?? ''?>'
                                    data-param='<?=$responses[$status]['param'] ?? ''?>'
                                    data-toggle='<?=$responses[$status]['toggle'] ?? ''?>'
                                    data-auto='<?=$auto ?? ''?>'>
                                    <?=$msg?>
                                </p>
                            <?php endforeach; ?>
                            <span class="message-scroll-icon small">【CLICK】</span>
                            <button type="button" id="cancel-evolve" class="btn btn-danger" style="display:none;">進化させない</button>
                        </div>
                    </div>
                </div>
            </section>
            <?php
            # お知らせ
            include($root_path.'/Resources/Partials/Common/notice.php');
            ?>
        </div>
    </main>
    <?php
    # footerの読み込み
    include($root_path.'/Resources/Partials/Layouts/Foot/footer.php');
    # モーダルの読み込み
    foreach($modals as $modal){
        include($root_path.'/Resources/Partials/Evolve/Modals/'.$modal['modal'].'.php');
    }
    # JSの読み込み
    include($root_path.'/Resources/Partials/Layouts/Foot/js.php');
    ?>
    <script src="/Assets/js/forget-move.js" type="text/javascript" defer></script>
    <script src="/Assets/js/Evolve/message.js" type="text/javascript" defer></script>
</body>
</html>
