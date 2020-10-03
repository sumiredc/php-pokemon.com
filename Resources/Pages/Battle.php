<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/App/Controllers/Battle/BattleController.php');
require_once($root_path.'/Resources/Lang/Translation.php');
$controller = new BattleController();
$pokemon = $controller->getPokemon();
$enemy = $controller->getEnemy();
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
                    <div class="col-12">
                        <h1 class="py-3">PHPポケモン</h1>
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
                                <div class="progress-bar bg-success" role="progressbar" style="width:<?=$enemy->getRemainingHp('per')?>%;" aria-valuenow="<?=$enemy->getRemainingHp()?>" aria-valuemin="0" aria-valuemax="<?=$enemy->getStats('HP')?>"></div>
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
                                <?php if($pokemon->getRemainingHp('per') <= 50) $hp_bar_class = 'bg-warning'; ?>
                                <?php if($pokemon->getRemainingHp('per') <= 20) $hp_bar_class = 'bg-danger'; ?>
                                <div class="progress-bar <?=$hp_bar_class ?? 'bg-success'?>" role="progressbar" style="width:<?=$pokemon->getRemainingHp('per')?>%;" aria-valuenow="<?=$pokemon->getRemainingHp()?>" aria-valuemin="0" aria-valuemax="<?=$pokemon->getStats('HP')?>"></div>
                            </div>
                            <p class="text-right px-3"><?=$pokemon->getRemainingHp()?> / <?=$pokemon->getStats('HP')?></p>
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
                            <?php foreach($controller->getMessages() as $key => list($msg, $status)): ?>
                                <?php $class = $key === $controller->getMessageFirstKey() ? 'active' : ''; ?>
                                <?php $last_class = $key === $controller->getMessageLastKey() ? 'last-message' : ''; ?>
                                <p class="result-message <?=$class?> <?=$last_class?> <?=$status ?? ''?>"><?=$msg?></p>
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
            <section>
                <div class="row">
                    <div class="col-12">
                        <?php $controller->setResponse($pokemon->getRank()); ?>
                        <?php $controller->setResponse($pokemon->getSc()); ?>
                        <pre><?php var_export($controller->getResponses()); ?></pre>
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
    <script src="/Assets/js/Battle/move.js" type="text/javascript"></script>
    <script src="/Assets/js/Battle/message.js" type="text/javascript"></script>
</body>
</html>
