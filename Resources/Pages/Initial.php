<?php
$root_path = __DIR__.'/../..';
?>
<!DOCTYPE html>
<html lang="jp" dir="ltr">
<head>
    <?php
    # metaの読み込み
    include(resources_path('Partials/Layouts/Head').'meta.php');
    # cssの読み込み
    include(resources_path('Partials/Layouts/Head').'css.php');
    ?>
    <link rel="stylesheet" href="/Assets/css/Page/initial.css">
</head>
<body>
    <?php
    # headerの読み込み
    include(resources_path('Partials/Layouts/Head').'header.php');
    ?>
    <main>
        <div class="container-fluid bg-php-back section">
            <section class="pt-3">
                <div class="row">
                    <div class="col-12 text-right">
                        <button type="button" class="btn btn-sm btn-php-dark" data-toggle="modal" data-target="#load-modal">続きから始める</button>
                    </div>
                </div>
            </section>
            <hr>
            <section class="py-3">
                <div class="row justify-content-center">
                    <div class="col-12 text-center mb-5">
                        <img src="/Assets/img/player/red/large/front.gif" alt="トレーナー">
                    </div>
                    <div class="col-8 col-md-4">
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="name-addon">名前</span>
                            </div>
                            <input type="text" id="player-name" class="form-control" aria-label="名前" placeholder="５文字以内" aria-describedby="name-addon" value="レッド">
                        </div>
                    </div>
                </div>
            </section>
            <hr>
            <section>
                <h3 class="mb-3 h5 text-center font-weight-bolder text-php-head">一緒に旅をするポケモンを選んでください</h3>
                <div class="row justify-content-center">
                    <?php foreach(config('const.first_pokemon') as $pokemon): ?>
                        <div class="col-3 col-sm-2">
                            <figure class="first-pokemon">
                                <img src="/Assets/img/ball/monster_ball.png" alt="<?=$pokemon::NAME?>" data-toggle="modal" data-target="#first-pokemon-<?=$pokemon?>-modal">
                            </figure>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
            <section class="p-3">
                <div class="row">
                    <div class="col-12">
                        <div class="message-box border p-3">
                            <?php foreach(response()->messages() as list($message)): ?>
                                <p class="mb-0 text-danger"><?=$message?></p>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
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
    include(resources_path('Partials/Initial/Modals').'pokemon.php');
    include(resources_path('Partials/Initial/Modals').'load.php');
    # JSの読み込み
    include(resources_path('Partials/Layouts/Foot').'js.php');
    ?>
    <script src="/Assets/js/Initial/initial.js" type="text/javascript" defer></script>
</body>
</html>
