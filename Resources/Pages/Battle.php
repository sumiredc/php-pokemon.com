<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/App/Controllers/Battle/BattleController.php');
require_once($root_path.'/Resources/Lang/Translation.php');
$controller = new BattleController();
$pokemon = $controller->getPokemon();
$enemy = $controller->getEnemy();
$responses = $controller->getResponses();
// 引き継ぐデータをセッションへ格納
$_SESSION['__data']['pokemon'] = $pokemon->export(); # 自ポケモンの情報をセッションに格納
$_SESSION['__data']['enemy'] = $enemy->export(); # 敵ポケモンの情報をセッションに格納
$_SESSION['__data']['run'] = $controller->run; # にげるの実行回数をセッションへ格納
$_SESSION['__data']['rank'] = [ # ランクをセッションに格納
'pokemon' => $pokemon->export('rank'),
'enemy' => $enemy->export('rank'),
];
$_SESSION['__data']['sc'] = [ # 状態変化をセッションに格納
'pokemon' => $pokemon->export('sc'),
'enemy' => $enemy->export('sc'),
];
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
    <header>
        <div class="container">
            <section>
                <div class="row">
                    <div class="col-12 d-flex justify-content-between py-3">
                        <h1>PHPポケモン</h1>
                        <div class="d-block">
                            <a href="https://s-yqual.com/blog/1324" target="_blank" role="button" class="btn btn-outline-secondary btn-sm" title="はじめに">はじめに</a>
                            <a href="https://s-yqual.com/contact" target="_blank" role="button" class="btn btn-outline-secondary btn-sm" title="不具合・問い合わせ">不具合・問い合わせ</a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </header>
    <main>
        <div class="container">
            <section>
                <div class="row mt-3 mb-5">
                    <?php # 敵ポケモン詳細 ?>
                    <div class="col-6">
                        <p><?=$enemy->getName()?> Lv:<?=$enemy->getLevel()?> <?=$enemy->getSaName(false)?></p>
                        <div class="form-group">
                            <div class="progress">
                                <div id="hpbar-enemy"
                                class="progress-bar bg-success"
                                role="progressbar"
                                style="width:<?=$controller->getBeforeRemainingHp($enemy, 'per')?>%;"
                                aria-valuenow="<?=$controller->getBeforeRemainingHp($enemy)?>"
                                aria-valuemin="0"
                                aria-valuemax="<?=$enemy->getStats('HP')?>"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 text-center">
                        <img src="/Assets/img/pokemon/dots/front/<?=get_class($enemy)?>.gif" alt="<?=$enemy->getName()?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <?php # 自ポケモン詳細 ?>
                    <div class="col-6 text-center">
                        <img src="/Assets/img/pokemon/dots/back/<?=get_class($pokemon)?>.gif" alt="<?=$pokemon->getName()?>">
                    </div>
                    <div class="col-6">
                        <p><?=$pokemon->getNickName()?> Lv:<?=$pokemon->getLevel()?> <?=$pokemon->getSaName(false)?></p>
                        <div class="form-group">
                            <div class="progress">
                                <?php if($controller->getBeforeRemainingHp($pokemon, 'per') <= 50) $hp_bar_class = 'bg-warning'; ?>
                                <?php if($controller->getBeforeRemainingHp($pokemon, 'per') <= 20) $hp_bar_class = 'bg-danger'; ?>
                                <div id="hpbar-friend"
                                class="progress-bar <?=$hp_bar_class ?? 'bg-success'?>"
                                role="progressbar"
                                style="width:<?=$controller->getBeforeRemainingHp($pokemon, 'per')?>%;"
                                aria-valuenow="<?=$controller->getBeforeRemainingHp($pokemon)?>"
                                aria-valuemin="0"
                                aria-valuemax="<?=$pokemon->getStats('HP')?>"></div>
                            </div>
                            <p class="text-right px-3">
                                <span id="remaining-hp-count-friend"><?=$controller->getBeforeRemainingHp($pokemon)?></span>
                                / <?=$pokemon->getStats('HP')?>
                            </p>
                            <?php # 経験値バー ?>
                            <div class="progress" style="height:4px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width:<?=$pokemon->getPerCompNexExp()?>%;" aria-valuenow="<?=$pokemon->getPerCompNexExp()?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="position-relative">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="message-box border p-3 mb-3">
                            <?php # メッセージエリア ?>
                            <?php foreach($controller->getMessages() as $key => list($msg, $status, $auto)): ?>
                                <?php $class = $key === $controller->getMessageFirstKey() ? 'active' : ''; ?>
                                <?php $last_class = $key === $controller->getMessageLastKey() ? 'last-message' : ''; ?>
                                <p class="result-message <?=$class?> <?=$last_class?> <?=$status ?? ''?>"
                                    data-action="<?=$responses[$status]['action'] ?? ''?>"
                                    data-target="<?=$responses[$status]['target'] ?? ''?>"
                                    data-param="<?=$responses[$status]['param'] ?? ''?>"
                                    data-auto="<?=$auto ?? ''?>">
                                    <?=$msg?>
                                </p>
                            <?php endforeach; ?>
                            <span class="message-scroll-icon">▼</span>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="row">
                            <div class="col-6 mb-2">
                                <button type="button" class="btn btn-outline-light btn-block action-btn" data-toggle="modal" data-target="#select-move-modal" id="action-btn-fight">たたかう</button>
                            </div>
                            <div class="col-6 mb-2">
                                <button type="button" class="btn btn-outline-light btn-block action-btn" id="action-btn-item">どうぐ</button>
                            </div>
                            <div class="col-6 mb-2">
                                <button type="button" class="btn btn-outline-light btn-block action-btn" id="action-btn-pokemon">ポケモン</button>
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
    <?php
    # モーダルの読み込み
    include($root_path.'/Resources/Partials/Battle/Modals/move.php');
    # footerの読み込み
    include($root_path.'/Resources/Partials/Layouts/Foot/footer.php');
    # JSの読み込み
    include($root_path.'/Resources/Partials/Layouts/Foot/js.php');
    ?>
    <script src="/Assets/js/Battle/fight.js" type="text/javascript"></script>
    <script src="/Assets/js/Battle/message.js" type="text/javascript"></script>
</body>
</html>
