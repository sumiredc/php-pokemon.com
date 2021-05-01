<!DOCTYPE html>
<html lang="jp" dir="ltr">
<head>
    <?php
    # metaの読み込み
    include resources_path('partials/layouts/head/meta.php');
    # cssの読み込み
    include resources_path('partials/layouts/head/css.php');
    ?>
    <link rel="stylesheet" href="/assets/css/page/home.css">
</head>
<body>
    <?php
    # headerの読み込み
    include resources_path('partials/layouts/head/header.php');
    ?>
    <main>
        <div class="container-fluid bg-php-back section">
            <section>
                <div class="row">
                    <?php
                    # メニュー
                    include resources_path('partials/common/menu.php');
                    ?>
                    <div class="col-12 mb-5 text-center">
                        <img src="/assets/img/player/red/large/front.gif" alt="プレイヤー" data-toggle="modal" data-target="#player-modal" />
                    </div>
                </div>
            </section>
            <hr>
            <section class="p-3">
                <div class="row">
                    <div class="col-12">
                        <?php
                        # メッセージボックス
                        include resources_path('partials/common/message-box.php');
                        ?>
                    </div>
                </div>
            </section>
            <hr>
            <section>
                <?php include resources_path('partials/home/action.php'); ?>
            </section>

        </div>
        <?php
        # お知らせ
        include resources_path('partials/common/notice.php');
        ?>
    </main>
    <?php
    # footerの読み込み
    include resources_path('partials/layouts/foot/footer.php');
    # モーダルの読み込み
    include resources_path('partials/common/modals/report.php');
    include resources_path('partials/common/modals/party/party.php');
    include resources_path('partials/common/modals/item/item.php');
    include resources_path('partials/common/modals/item/item-trash.php');
    include resources_path('partials/common/modals/item/item-use-friend.php');
    include resources_path('partials/home/modals/pokedex.php');
    include resources_path('partials/home/modals/player.php');
    include resources_path('partials/home/modals/shop.php');
    include resources_path('partials/home/modals/reset.php');
    include resources_path('partials/home/modals/pokemon-center.php');
    include resources_path('partials/home/modals/field.php');
    include resources_path('partials/home/modals/trainer.php');
    include resources_path('partials/home/modals/gym.php');
    foreach(response()->modals() as $modal){
        include resources_path('partials/home/modals/'.$modal['modal'].'.php');
    }
    # JSの読み込み
    include resources_path('partials/layouts/foot/js.php');
    ?>
    <script src="/assets/js/common/action-message.js" type="text/javascript" defer></script>
    <script src="/assets/js/common/forget-move.js" type="text/javascript" defer></script>
    <script src="/assets/js/common/item.js" type="text/javascript" defer></script>
    <script src="/assets/js/home/home.js" type="text/javascript" defer></script>
    <script src="/assets/js/home/pokedex.js" type="text/javascript" defer></script>
    <script src="/assets/js/home/shop.js" type="text/javascript" defer></script>
    <script src="/assets/js/home/party.js" type="text/javascript" defer></script>
</body>
</html>
