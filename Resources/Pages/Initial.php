<?php
$root_path = __DIR__.'/../..';
// require_once($root_path.'/Resources/Partials/Layouts/Head/initial.php');
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
                    <div class="col-4 text-center">
                        <img src="/Assets/img/player/red/large/front.gif" alt="トレーナー">
                    </div>
                    <div class="col-8">
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
                <h3 class="mb-3 h5">一緒に旅をするポケモンを選んでください</h3>
                <div class="row">
                    <?php foreach($controller->getPokemonList() as $key => $name): ?>
                        <div class="col-6 col-sm-3">
                            <figure class="first-pokemon">
                                <img src="/Assets/img/ball/monster_ball.png" alt="<?=$name?>" data-toggle="modal" data-target="#<?=$key?>-modal">
                            </figure>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if($messages): ?>
                    <div class="row">
                        <?php foreach($messages as list($message)): ?>
                            <div class="col-12">
                                <p class="text-danger"><?=$message?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
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
    # モーダルの読み込み
    include($root_path.'/Resources/Partials/Initial/Modals/pokemon.php');
    # JSの読み込み
    include($root_path.'/Resources/Partials/Layouts/Foot/js.php');
    ?>
    <script src="/Assets/js/Initial/initial.js" type="text/javascript" defer></script>
</body>
</html>
