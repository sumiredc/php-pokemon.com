<!DOCTYPE html>
<html lang="jp" dir="ltr">
<head>
    <?php
    # metaの読み込み
    include resources_path('partials/layouts/head/meta.php');
    # cssの読み込み
    include resources_path('partials/layouts/head/css.php');
    ?>
    <link rel="stylesheet" href="/assets/css/page/battle.css">
</head>
<body>
    <?php
    # headerの読み込み
    include resources_path('partials/layouts/head/header.php');
    ?>
    <main>
        <div class="container-fluid section bg-php-back">
             <?php
             # フィールドの読み込み
             include resources_path('partials/battle/field.php');
             # 操作パネルの読み込み
             include resources_path('partials/battle/controls.php');
              ?>
        </div>
    </main>
    <?php
    # footerの読み込み
    include resources_path('partials/layouts/foot/footer.php');
    # モーダルの読み込み
    foreach(response()->modals() as $modal){
        if(isset($modal['modal'])){
            include resources_path('partials/battle/modals/'.$modal['modal'].'.php');
        }
    }
    include resources_path('partials/battle/modals/battle-states.php');
    include resources_path('partials/battle/modals/move.php');
    include resources_path('partials/battle/modals/surrender.php');
    include resources_path('partials/common/modals/party/party.php');
    include resources_path('partials/common/modals/item/item.php');
    include resources_path('partials/common/modals/item/item-use-friend.php');
    # テンプレートの読み込み
    include resources_path('partials/layouts/templates/template-effects.php');
    # JSの読み込み
    include resources_path('partials/layouts/foot/js.php');
    ?>
    <script src="/assets/js/common/item.js" type="text/javascript" defer></script>
    <script src="/assets/js/common/forget-move.js" type="text/javascript" defer></script>
    <script src="/assets/js/common/action-message.js" type="text/javascript" defer></script>
    <script src="/assets/js/battle/fight.js" type="text/javascript" defer></script>
    <script src="/assets/js/battle/party.js" type="text/javascript" defer></script>
    <script src="/assets/js/battle/library-battle.js" type="text/javascript" defer></script>
</body>
</html>
