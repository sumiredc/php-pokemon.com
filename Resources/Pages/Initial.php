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
                <h3 class="mb-3 text-center">一緒に旅をするポケモンを選んでください</h3>
                <div class="row">
                    <?php foreach($controller->getPokemonList() as $key => $name): ?>
                        <?php #if($key === 'Mew') continue; ?>
                        <div class="col-6 col-sm-3">
                            <figure class="first-pokemon">
                                <img src="/Assets/img/ball/monster_ball.png" alt="<?=$name?>" data-toggle="modal" data-target="#<?=$key?>-modal">
                            </figure>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
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
