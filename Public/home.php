<?php
require_once(__DIR__.'/../Classes/Controller/HomeController.php');
require_once(__DIR__.'/../Resources/Lang/Translation.php');
session_start();
$controller = new HomeController();
$pokemon = $controller->getPokemon();
$_SESSION['pokemon'] = $pokemon->export(); # ポケモンの情報をセッションに格納
?>
<!DOCTYPE html>
<html lang="jp" dir="ltr">
<head>
    <?php
    # metaの読み込み
    include(__DIR__.'/../Resources/Partials/Layouts/Head/meta.php');
    # cssの読み込み
    include(__DIR__.'/../Resources/Partials/Layouts/Head/css.php');
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
                <div class="row my-5">
                    <div class="col-3 offset-md-2 text-center">
                        <img src="/Assets/img/pokemon/dots/front/<?=get_class($pokemon)?>.gif" alt="<?=$pokemon->getName()?>" style="cursor:pointer;" data-toggle="modal" data-target="#pokemon-details-modal">
                    </div>
                    <div class="col-9 col-md-5">
                        <p><?=$pokemon->getNickName()?> Lv:<?=$pokemon->getLevel()?> <?=$pokemon->getSaName()?></p>
                        <div class="form-group">
                            <?php # HPバー ?>
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
            <section>
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="message-box border p-3 mb-3">
                            <?php foreach($controller->getMessages() as list($msg, $status)): ?>
                                <p><?=$msg?></p>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <?php include(__DIR__.'/../Resources/Partials/Home/Forms/change_nickname.php'); # ニックネームの変更?>
                        <?php include(__DIR__.'/../Resources/Partials/Home/Forms/add_exp.php'); # 経験値の取得 ?>
                        <?php include(__DIR__.'/../Resources/Partials/Home/Forms/battle.php'); # バトル ?>
                        <?php include(__DIR__.'/../Resources/Partials/Home/Forms/reset.php'); # リセット ?>
                    </div>
                </div>
            </section>
            <section>
                <div class="row">
                    <div class="col-12">
                        <?php $controller->setResponse(['努力値' => $pokemon->getEv()]); ?>
                        <pre><?php var_export($controller->getResponses()); ?></pre>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <?php
    # JSの読み込み
    include(__DIR__.'/../Resources/Partials/Layouts/Foot/js.php');
    ?>
    <script src="/Assets/js/Home/details.js" type="text/javascript"></script>
    <?php
    # モーダルの読み込み
    include(__DIR__.'/../Resources/Partials/Home/Modals/details.php');
    ?>
</body>
</html>
