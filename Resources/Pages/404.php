<!DOCTYPE html>
<html lang="jp" dir="ltr">
<head>
    <?php
    # metaの読み込み
    include(resources_path('Partials.Layouts.Head').'meta.php');
    # cssの読み込み
    include(resources_path('Partials.Layouts.Head').'css.php');
    ?>
</head>
<body>
    <?php
    # headerの読み込み
    include(resources_path('Partials.Layouts.Head').'header.php');
    ?>
    <main>
        <div class="container-fluid section bg-php-back">
            <section class="px-3 py-4">
                <h2 class="text-php-head font-weight-bold mb-4">ページが見つかりませんでした...</h2>
                <?php if($controller->isPlayer()): ?>
                    <figure class="p-5 text-center">
                        <img src="/Assets/img/pokemon/3d/<?=$controller->koiking()?>.gif" alt="コイキング" />
                    </figure>
                <?php endif; ?>
                <div class="text-center">
                    <a href="/" class="btn btn-php-dark btn-lg">ゲーム画面へ戻る</a>
                </div>
            </section>
            <section class="p-3">
                <div class="row">
                    <div class="col-12">
                        <div class="message-box border p-3">
                            <?php if($controller->isPlayer()): ?>
                                <p class="mb-0">あっ！コイキングを見つけた！</p>
                            <?php else: ?>
                                <p class="text-danger">
                                    申し訳ございません、要求されたページは存在していません。「ゲーム画面へ戻る」を押してください。
                                </p>
                            <?php endif; ?>
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
    # JSの読み込み
    include(resources_path('Partials.Layouts.Foot').'js.php');
    ?>
</body>
</html>
