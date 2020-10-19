<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/App/Controllers/Initial/InitialController.php');
$controller = new InitialController();
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
                <h3 class="mb-3">一緒に旅をするポケモンを選んでください</h3>
                <div class="row">
                    <?php foreach($controller->getPokemonList() as $key => $name): ?>
                        <div class="col-6 col-sm-3">
                            <figure class="first-pokemon">
                                <img src="/Assets/img/ball/monster_ball.png" alt="<?=$name?>" data-toggle="modal" data-target="#<?=$key?>-modal">
                            </figure>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if($controller->getMessages()): ?>
                    <div class="row">
                        <?php foreach($controller->getMessages() as list($message)): ?>
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
    # モーダルの読み込み
    include($root_path.'/Resources/Partials/Initial/Modals/pokemon.php');
    # footerの読み込み
    include($root_path.'/Resources/Partials/Layouts/Foot/footer.php');
    # JSの読み込み
    include($root_path.'/Resources/Partials/Layouts/Foot/js.php');
    ?>
</body>
</html>
