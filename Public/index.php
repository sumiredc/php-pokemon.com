<?php
require_once(__DIR__.'/../Classes/Controller/IndexController.php');
session_start();
$controller = new IndexController();
?>
<!DOCTYPE html>
<html lang="jp" dir="ltr">
<head>
    <?php
    # metaの読み込み
    include(__DIR__.'/../Resources/Partials/Layouts/Head/meta.php');
    # cssの読み込み
    include(__DIR__.'/../Resources/Partials/Layouts/Head/css.php');
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
                <div class="row">
                    <div class="col-12 col-sm-6 mb-5">
                        <h2 class="mb-3">最初のポケモンを選択</h2>
                        <?php include(__DIR__.'/../Resources/Partials/Index/Forms/select_pokemon.php'); ?>
                    </div>
                    <div class="col-12 col-sm-6 mb-5">
                        <div class="message-box border p-3 mb-3">
                            <?php foreach($controller->getMessages() as list($msg, $status)): ?>
                                <p><?=$msg?></p>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>
</html>
