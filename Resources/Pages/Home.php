<!DOCTYPE html>
<html lang="jp" dir="ltr">
<head>
    <?php
    # metaの読み込み
    include(resources_path('Partials/Layouts/Head').'meta.php');
    # cssの読み込み
    include(resources_path('Partials/Layouts/Head').'css.php');
    ?>
    <link rel="stylesheet" href="/Assets/css/Page/home.css">
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
                    <?php
                    # メニュー
                    include(resources_path('Partials/Common').'menu.php');
                    ?>
                    <div class="col-12 mb-5 text-center">
                        <img src="/Assets/img/player/red/large/front.gif" alt="プレイヤー">
                    </div>
                </div>
            </section>
            <hr>
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
            <hr>
            <section>
                <?php include(resources_path('Partials/Home').'action.php'); ?>
            </section>

        </div>
        <?php
        # お知らせ
        include(resources_path('Partials/Common').'notice.php');
        ?>
    </main>
    <?php
    # footerの読み込み
    include(resources_path('Partials/Layouts/Foot').'footer.php');
    # モーダルの読み込み
    include(resources_path('Partials/Common/Modals').'report.php');
    include(resources_path('Partials/Common/Modals/Party').'party.php');
    include(resources_path('Partials/Common/Modals/Item').'item.php');
    include(resources_path('Partials/Common/Modals/Item').'item-trash.php');
    include(resources_path('Partials/Common/Modals/Item').'item-use-friend.php');
    include(resources_path('Partials/Home/Modals').'pokedex.php');
    include(resources_path('Partials/Home/Modals').'player.php');
    include(resources_path('Partials/Home/Modals').'shop.php');
    include(resources_path('Partials/Home/Modals').'reset.php');
    include(resources_path('Partials/Home/Modals').'pokemon-center.php');
    include(resources_path('Partials/Home/Modals').'field.php');
    include(resources_path('Partials/Home/Modals').'trainer.php');
    foreach(response()->modals() as $modal){
        include(resources_path('Partials/Home/Modals').$modal['modal'].'.php');
    }
    # JSの読み込み
    include(resources_path('Partials/Layouts/Foot').'js.php');
    ?>
    <script src="/Assets/js/Common/action-message.js" type="text/javascript" defer></script>
    <script src="/Assets/js/Common/forget-move.js" type="text/javascript" defer></script>
    <script src="/Assets/js/Common/item.js" type="text/javascript" defer></script>
    <script src="/Assets/js/Home/home.js" type="text/javascript" defer></script>
    <script src="/Assets/js/Home/pokedex.js" type="text/javascript" defer></script>
    <script src="/Assets/js/Home/shop.js" type="text/javascript" defer></script>
    <script src="/Assets/js/Home/party.js" type="text/javascript" defer></script>
</body>
</html>
