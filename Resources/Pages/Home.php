<?php
$root_path = __DIR__.'/../..';
?>
<!DOCTYPE html>
<html lang="jp" dir="ltr">
<head>
    <?php
    # metaの読み込み
    include(resources_path('Partials.Layouts.Head').'meta.php');
    # cssの読み込み
    include(resources_path('Partials.Layouts.Head').'css.php');
    ?>
    <link rel="stylesheet" href="/Assets/css/Page/home.css">
</head>
<body>
    <?php
    # headerの読み込み
    include(resources_path('Partials.Layouts.Head').'header.php');
    ?>
    <main>
        <div class="container-fluid bg-php-back section">
            <section>
                <div class="row">
                    <?php
                    # メニュー
                    include(resources_path('Partials.Common').'menu.php');
                    ?>
                    <div class="col-12 mb-5 text-center">
                        <img src="/Assets/img/player/red/large/front.gif" alt="プレイヤー">
                    </div>
                </div>
            </section>
            <hr>
            <section>
                <?php include(resources_path('Partials.Home').'action.php'); ?>
            </section>
            <section class="p-3">
                <div class="row">
                    <div class="col-12">
                        <div class="message-box border p-3">
                            <?php foreach(response()->messages() as list($message)): ?>
                                <p class="mb-0"><?=$message?></p>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php
        # お知らせ
        include(resources_path('Partials.Common').'notice.php');
        ?>
    </main>
    <?php
    # footerの読み込み
    include(resources_path('Partials.Layouts.Foot').'footer.php');
    # モーダルの読み込み
    include(resources_path('Partials.Common.Modals.Party').'party.php');
    include(resources_path('Partials.Common.Modals.Item').'item.php');
    include(resources_path('Partials.Common.Modals.Item').'item-trash.php');
    include(resources_path('Partials.Common.Modals.Item').'item-use-friend.php');
    include(resources_path('Partials.Home.Modals').'pokedex.php');
    include(resources_path('Partials.Home.Modals').'player.php');
    include(resources_path('Partials.Home.Modals').'shop.php');
    include(resources_path('Partials.Home.Modals').'reset.php');
    include(resources_path('Partials.Home.Modals').'pokemon-center.php');
    include(resources_path('Partials.Home.Modals').'field.php');
    # JSの読み込み
    include(resources_path('Partials.Layouts.Foot').'js.php');
    ?>
    <script src="/Assets/js/Common/item.js" type="text/javascript" defer></script>
    <script src="/Assets/js/Home/home.js" type="text/javascript" defer></script>
    <script src="/Assets/js/Home/pokedex.js" type="text/javascript" defer></script>
    <script src="/Assets/js/Home/shop.js" type="text/javascript" defer></script>
    <script src="/Assets/js/Home/party.js" type="text/javascript" defer></script>
</body>
</html>
