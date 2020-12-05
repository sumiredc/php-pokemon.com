<!DOCTYPE html>
<html lang="jp" dir="ltr">
<head>
    <?php
    # metaの読み込み
    include(resources_path('Partials.Layouts.Head').'meta.php');
    # cssの読み込み
    include(resources_path('Partials.Layouts.Head').'css.php');
    ?>
    <link rel="stylesheet" href="/Assets/css/Page/pokebox.css">
</head>
<body>
    <?php
    # headerの読み込み
    include(resources_path('Partials.Layouts.Head').'header.php');
    ?>
    <main>
        <div class="container-fluid section">
            <section>
                <div class="card">
                    <div class="card-header bg-php d-flex align-items-center justify-content-between">
                        <h5 class="mb-0 font-weight-bolder">
                            <img src="/Assets/img/icon/pokebox.png" class="mr-2" alt="ポケモン預かりシステム" />
                            ポケモン預かりシステム
                        </h5>
                        <button type="button" class="btn btn-danger rounded-circle p-0" style="width:40px;height:40px;" data-submit_remote="shutdown" title="終了する">
                            <i class="fas fa-power-off"></i>
                        </button>
                    </div>
                    <div class="card-body py-0 px-3">
                        <div class="row">
                            <?php include(resources_path('Partials.Pokebox').'body.php'); ?>
                        </div>
                    </div>
                    <div class="card-footer bg-php d-flex justify-content-center" data-pokebox="controls">
                        <?php include(resources_path('Partials.Pokebox').'foot.php'); ?>
                    </div>
                    <div class="card-footer p-3 overflow-auto bg-white" style="height: 90px;">
                        <?php foreach(response()->messages() as list($message)): ?>
                            <p class="mb-0"><?=$message?></p>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <?php
    # footerの読み込み
    include(resources_path('Partials.Layouts.Foot').'footer.php');
    # モーダルの読み込み
    include(resources_path('Partials.Pokebox.Modals').'deposit.php');
    include(resources_path('Partials.Pokebox.Modals').'receive.php');
    include(resources_path('Partials.Pokebox.Modals').'switch.php');
    # JSの読み込み
    include(resources_path('Partials.Layouts.Foot').'js.php');
    ?>
    <script src="/Assets/js/Pokebox/pokebox.js" type="text/javascript" defer></script>
</body>
</html>
