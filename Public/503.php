<?php
/**
* メンテナンスモード(503)
*/
http_response_code(503);
$root_path = __DIR__.'/..';
// ポケモンをランダムで取得
$pokemon = random_int(1, 3);
// 画像の取得
$image = '503-'.$pokemon;
// 色違いの判定
if(!random_int(0, 8192)){
    $shiny = 'shiny';
}else{
    $shiny = '';
}
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
            <div class="container-fluid bg-php-back section">
                <section class="px-3 py-4">
                    <h2 class="text-php-head font-weight-bold mb-4">メンテナンス中...</h2>
                    <figure class="p-5 text-center">
                        <img src="/Assets/img/pokemon/3d/<?=$image.$shiny?>.gif" alt="メンテナンスポケモン" />
                    </figure>
                </section>
                <section class="p-3">
                    <div class="row">
                        <div class="col-12">
                            <div class="message-box border p-3">
                                <p class="mb-0">あっ！<?php if($shiny) echo '色違いの'; ?><?=config('const.503.'.$pokemon)?>だ！</p>
                                <p class="mb-0">しかし、今はポケモン図鑑を持っていない・・・残念。</p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
        <?php
        # footerの読み込み
        include($root_path.'/Resources/Partials/Layouts/Foot/footer.php');
        # JSの読み込み
        include($root_path.'/Resources/Partials/Layouts/Foot/js.php');
        ?>
    </body>
</html>
