<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/App/Controllers/Home/HomeController.php');
require_once($root_path.'/Resources/Lang/Translation.php');
$controller = new HomeController();
$pokemon = $controller->getPokemon();
$_SESSION['__data']['pokemon'] = $pokemon->export(); # ポケモンの情報をセッションに格納
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
                    <div class="col-12 mb-5">
                        <div class="btn-group float-right">
                            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                メニュー
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <span class="dropdown-item p-0">
                                    <?php include($root_path.'/Resources/Partials/Home/Forms/pokemon_center.php'); # ポケモンセンター ?>
                                </span>
                                <span class="dropdown-item p-0">
                                    <?php include($root_path.'/Resources/Partials/Home/Forms/battle.php'); # バトル ?>
                                </span>
                                <div class="dropdown-divider"></div>
                                <span class="dropdown-item p-0">
                                    <button class="btn btn-link text-danger btn-block text-left font-weight-bolder px-4" data-toggle="modal" data-target="#reset-modal">リセット</button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-5">
                        <div class="row">
                            <div class="col-12 col-sm-3 offset-md-2 text-center">
                                <img src="/Assets/img/pokemon/dots/front/<?=get_class($pokemon)?>.gif" class="mb-5" alt="<?=$pokemon->getName()?>" style="cursor:pointer;" data-toggle="modal" data-target="#pokemon-details-modal">
                            </div>
                            <div class="col-12 col-sm-9 col-md-5">
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
                    </div>
                </div>
            </section>
            <section>
                <div class="row">
                    <div class="col-12">
                        <div class="message-box border p-3 mb-3">
                            <?php foreach($controller->getMessages() as list($msg)): ?>
                                <p><?=$msg?></p>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </section>
            <?php
            # お知らせ
            include($root_path.'/Resources/Partials/Common/info.php');
            ?>
        </div>
    </main>
    <?php
    # モーダルの読み込み
    include($root_path.'/Resources/Partials/Home/Modals/details.php');
    include($root_path.'/Resources/Partials/Home/Modals/reset.php');
    # footerの読み込み
    include($root_path.'/Resources/Partials/Layouts/Foot/footer.php');
    # JSの読み込み
    include($root_path.'/Resources/Partials/Layouts/Foot/js.php');
    ?>
    <script src="/Assets/js/Home/details.js" type="text/javascript"></script>
</body>
</html>
