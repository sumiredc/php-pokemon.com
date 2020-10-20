<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Resources/Partials/Layouts/Head/battle.php');
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
                <div class="row mt-3 mb-5">
                    <?php # 敵ポケモン詳細 ?>
                    <div class="col-6">
                        <p>
                            <span class="mr-2"><?=$before_enemy->getName()?></span>
                            <span class="mr-2">Lv:<?=$before_enemy->getLevel()?></span>
                            <span class="mr-2 badge badge-<?=$before_enemy->getSaColor()?>"><?=$before_enemy->getSaName(false)?></span>
                        </p>
                        <div class="form-group">
                            <div class="progress">
                                <div id="hpbar-enemy"
                                class="progress-bar bg-success"
                                role="progressbar"
                                style="width:<?=$before_enemy->getRemainingHp('per')?>%;"
                                aria-valuenow="<?=$before_enemy->getRemainingHp()?>"
                                aria-valuemin="0"
                                aria-valuemax="<?=$before_enemy->getStats('HP')?>"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 text-center">
                        <img src="/Assets/img/pokemon/dots/front/<?=get_class($before_enemy)?>.gif" alt="<?=$before_enemy->getName()?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <?php # 自ポケモン詳細 ?>
                    <div class="col-6 text-center">
                        <img src="/Assets/img/pokemon/dots/back/<?=get_class($before_pokemon)?>.gif" alt="<?=$before_pokemon->getName()?>">
                    </div>
                    <div class="col-6">
                        <p>
                            <span class="mr-2"><?=$pokemon->getNickName()?></span>
                            <span class="mr-2">Lv:<span id="level"><?=$before_pokemon->getLevel()?></span></span>
                            <span class="mr-2 badge badge-<?=$before_pokemon->getSaColor()?>"><?=$before_pokemon->getSaName(false)?></span>
                        </p>
                        <div class="form-group">
                            <div class="progress">
                                <?php if($before_pokemon->getRemainingHp('per') <= 20) $hp_bar_class = 'bg-danger'; ?>
                                <?php if($before_pokemon->getRemainingHp('per') <= 50) $hp_bar_class = 'bg-warning'; ?>
                                <div id="hpbar-friend"
                                class="progress-bar <?=$hp_bar_class ?? 'bg-success'?>"
                                role="progressbar"
                                style="width:<?=$before_pokemon->getRemainingHp('per')?>%;"
                                aria-valuenow="<?=$before_pokemon->getRemainingHp()?>"
                                aria-valuemin="0"
                                aria-valuemax="<?=$before_pokemon->getStats('HP')?>"></div>
                            </div>
                            <p class="text-right px-3">
                                <span id="remaining-hp-count-friend"><?=$before_pokemon->getRemainingHp()?></span>
                                / <span id="max-hp-count-friend"><?=$before_pokemon->getStats('HP')?></span>
                            </p>
                            <?php # 経験値バー ?>
                            <div class="progress" style="height:4px;">
                                <div id="expbar"
                                class="progress-bar bg-primary"
                                role="progressbar"
                                style="width:<?=$before_pokemon->getPerCompNexExp()?>%;"
                                aria-valuenow="<?=$before_pokemon->getPerCompNexExp()?>"
                                aria-valuemin="0"
                                aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="position-relative">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="message-box action-message-box border p-3 mb-3">
                            <?php # メッセージエリア ?>
                            <?php foreach($controller->getMessages() as $key => list($msg, $status, $auto)): ?>
                                <?php $class = $key === $controller->getMessageFirstKey() ? 'active' : ''; ?>
                                <?php $last_class = $key === $controller->getMessageLastKey() ? 'last-message' : ''; ?>
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
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="row">
                            <div class="col-6 mb-2">
                                <?php if($pokemon->checkUsedMove()): ?>
                                    <button type="button" class="btn btn-outline-light btn-block action-btn" data-toggle="modal" data-target="#select-move-modal" id="action-btn-fight">たたかう</button>
                                <?php else: ?>
                                    <form method="post">
                                        <input type="hidden" name="action" value="fight">
                                        <input type="submit" class="btn btn-outline-light btn-block action-btn" value="たたかう">
                                        <?php input_token(); ?>
                                    </form>
                                <?php endif; ?>
                            </div>
                            <div class="col-6 mb-2">
                                <button type="button" class="btn btn-outline-light btn-block action-btn" data-toggle="modal" data-target="#select-item-modal" id="action-btn-item">どうぐ</button>
                            </div>
                            <div class="col-6 mb-2">
                                <button type="button" class="btn btn-outline-light btn-block action-btn" data-toggle="modal" data-target="#select-pokemon-modal" id="action-btn-pokemon">ポケモン</button>
                            </div>
                            <div class="col-6 mb-2">
                                <form action="" method="post">
                                    <div class="input-group mb-3">
                                        <input type="hidden" name="action" value="run">
                                        <input class="btn btn-outline-light btn-block action-btn" id="action-btn-run" type="submit" value="逃げる">
                                        <?php input_token(); ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <?php # 遠隔操作用隠しフォーム ?>
    <form action="" method="post" id="remote-form">
        <input type="hidden" name="action" id="remote-form-action">
        <?php input_token(); ?>
    </form>
    <?php foreach($controller->getModals() as $modal): ?>
        <?php include($root_path.'/Resources/Partials/Battle/Modals/'.$modal['modal'].'.php'); ?>
    <?php endforeach; ?>
    <?php
    # footerの読み込み
    include($root_path.'/Resources/Partials/Layouts/Foot/footer.php');
    # モーダルの読み込み
    include($root_path.'/Resources/Partials/Battle/Modals/move.php');
    include($root_path.'/Resources/Partials/Battle/Modals/item.php');
    include($root_path.'/Resources/Partials/Battle/Modals/pokemon.php');
    # JSの読み込み
    include($root_path.'/Resources/Partials/Layouts/Foot/js.php');
    ?>
    <script src="/Assets/js/Battle/fight.js" type="text/javascript"></script>
    <script src="/Assets/js/Battle/message.js" type="text/javascript"></script>
</body>
</html>
