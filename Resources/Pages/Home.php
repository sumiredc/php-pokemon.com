<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Resources/Partials/Layouts/Head/home.php');
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
                    <?php include($root_path.'/Resources/Partials/Common/menu.php'); #メニュー ?>
                    <div class="col-12 mb-5 text-center">
                        <img src="/Assets/img/player/red/large/front.gif"
                        class="mb-5"
                        alt="プレイヤー">
                    </div>
                </div>
            </section>
            <section>
                <?php include($root_path.'/Resources/Partials/Home/action.php'); ?>
            </section>
            <section class="bg-light p-3">
                <div class="row">
                    <div class="col-12">
                        <div class="message-box border p-3">
                            <?php foreach($messages as list($message)): ?>
                                <p><?=$message?></p>
                            <?php endforeach; ?>
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
    include($root_path.'/Resources/Partials/Home/Modals/party.php');
    include($root_path.'/Resources/Partials/Home/Modals/item.php');
    include($root_path.'/Resources/Partials/Home/Modals/player.php');
    include($root_path.'/Resources/Partials/Home/Modals/shop.php');
    # モーダルの読み込み
    foreach($controller->getParty() as $order => $party){
        include($root_path.'/Resources/Partials/Home/Modals/details.php');
    }
    include($root_path.'/Resources/Partials/Home/Modals/reset.php');
    # JSの読み込み
    include($root_path.'/Resources/Partials/Layouts/Foot/js.php');
    ?>
    <script src="/Assets/js/Common/item.js" type="text/javascript" defer></script>
    <script src="/Assets/js/Home/shop.js" type="text/javascript" defer></script>
</body>
</html>
