<?php
$root_path = __DIR__.'/../..';
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
    <link rel="stylesheet" href="/Assets/css/Page/battle.css">
</head>
<body>
    <?php
    # headerの読み込み
    include($root_path.'/Resources/Partials/Layouts/Head/header.php');
    ?>
    <main>
        <div class="container-fluid section bg-php-back">
            <?php
            # フィールドの読み込み
            include($root_path.'/Resources/Partials/Battle/field.php');
             ?>
             <?php
             # 操作パネルの読み込み
             include($root_path.'/Resources/Partials/Battle/controls.php');
              ?>
        </div>
    </main>
    <?php
    # footerの読み込み
    include($root_path.'/Resources/Partials/Layouts/Foot/footer.php');
    # モーダルの読み込み
    foreach(response()->modals() as $modal){
        if(isset($modal['modal'])){
            include($root_path.'/Resources/Partials/Battle/Modals/'.$modal['modal'].'.php');
        }
    }
    include($root_path.'/Resources/Partials/Battle/Modals/battle-states.php');
    include($root_path.'/Resources/Partials/Battle/Modals/move.php');
    include($root_path.'/Resources/Partials/Common/Modals/Party/party.php');
    include($root_path.'/Resources/Partials/Common/Modals/Item/item.php');
    include($root_path.'/Resources/Partials/Common/Modals/Item/item-use-friend.php');
    # テンプレートの読み込み
    include($root_path.'/Resources/Partials//Layouts/Templates/template-effects.php');
    # JSの読み込み
    include($root_path.'/Resources/Partials/Layouts/Foot/js.php');
    ?>
    <script src="/Assets/js/Common/item.js" type="text/javascript" defer></script>
    <script src="/Assets/js/Common/forget-move.js" type="text/javascript" defer></script>
    <script src="/Assets/js/Common/action-message.js" type="text/javascript" defer></script>
    <script src="/Assets/js/Battle/fight.js" type="text/javascript" defer></script>
    <script src="/Assets/js/Battle/party.js" type="text/javascript" defer></script>
    <script src="/Assets/js/Battle/library-battle.js" type="text/javascript" defer></script>
</body>
</html>
