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
</head>
<body>
    <?php
    # headerの読み込み
    include($root_path.'/Resources/Partials/Layouts/Head/header.php');
    ?>
    <main>
        <div class="container">
            <section id="battle-field">
                <div class="row mt-3 mb-5 py-3">
                    <?php # 敵ポケモン詳細 ?>
                    <div class="col-6" id="enemy-pokemon-parameter">
                        <p>
                            <span class="mr-2" id="name-enemy"><?=$before_enemy->getNickName()?></span>
                            <span class="mr-2">Lv:<span id="level-enemy"><?=$before_enemy->getLevel()?></span></span>
                            <span class="mr-2 badge badge-<?=$before_enemy->getSaColor(false)?>" id="sa-enemy">
                                <?=$before_enemy->getSaName(false)?>
                            </span>
                        </p>
                        <div class="form-group">
                            <div class="progress">
                                <div id="hpbar-enemy"
                                class="progress-bar bg-success"
                                role="progressbar"
                                style="width:<?=$before_enemy->getRemainingHp('per')?>%;"
                                aria-valuenow="<?=$before_enemy->getRemainingHp()?>"
                                aria-valuemin="0"
                                aria-valuemax="<?=$before_enemy->getStats('HP')?>"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 text-center">
                        <input type="image"
                        id="enemy-pokemon-image"
                        class="action-img-btn"
                        src="/Assets/img/pokemon/dots/front/<?=get_class($before_enemy)?>.gif"
                        alt="<?=$before_enemy->getName()?>"
                        data-pokemon="<?=get_class($before_enemy)?>"
                        data-toggle="modal"
                        data-target="#enemy-battle-state-modal" />
                    </div>
                </div>
                <div class="row mb-3 py-3">
                    <?php # 自ポケモン詳細 ?>
                    <div class="col-6 text-center">
                        <input type="image"
                        id="friend-pokemon-image"
                        class="action-img-btn"
                        src="/Assets/img/pokemon/dots/back/<?=get_class($before_pokemon)?>.gif"
                        alt="<?=$before_pokemon->getName()?>"
                        data-pokemon="<?=get_class($before_pokemon)?>"
                        data-toggle="modal"
                        data-target="#friend-battle-state-modal" />
                    </div>
                    <div class="col-6" id="friend-pokemon-parameter">
                        <p>
                            <span class="mr-2" id="name-friend"><?=$before_pokemon->getNickName()?></span>
                            <span class="mr-2">Lv:<span id="level-friend"><?=$before_pokemon->getLevel()?></span></span>
                            <span class="mr-2 badge badge-<?=$before_pokemon->getSaColor(false)?>" id="sa-friend">
                                <?=$before_pokemon->getSaName(false)?>
                            </span>
                        </p>
                        <div class="form-group">
                            <div class="progress">
                                <?php if($before_pokemon->getRemainingHp('per') <= 20) $hp_bar_class = 'bg-danger'; ?>
                                <?php if($before_pokemon->getRemainingHp('per') <= 50) $hp_bar_class = 'bg-warning'; ?>
                                <div id="hpbar-friend"
                                class="progress-bar <?=$hp_bar_class ?? 'bg-success'?>"
                                role="progressbar"
                                style="width:<?=$before_pokemon->getRemainingHp('per')?>%;"
                                aria-valuenow="<?=$before_pokemon->getRemainingHp()?>"
                                aria-valuemin="0"
                                aria-valuemax="<?=$before_pokemon->getStats('HP')?>"></div>
                            </div>
                            <p class="text-right px-3">
                                <span id="remaining-hp-count-friend"><?=$before_pokemon->getRemainingHp()?></span>
                                / <span id="max-hp-count-friend"><?=$before_pokemon->getStats('HP')?></span>
                            </p>
                            <?php # 経験値バー ?>
                            <div class="progress" style="height:4px;">
                                <div id="expbar-friend"
                                class="progress-bar bg-primary"
                                role="progressbar"
                                style="width:<?=$before_pokemon->getPerCompNexExp()?>%;"
                                aria-valuenow="<?=$before_pokemon->getPerCompNexExp()?>"
                                aria-valuemin="0"
                                aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="position-relative bg-light p-3">
                <div class="row align-items-center">
                    <div class="col-12 col-sm-6 mb-3 mb-sm-0">
                        <div class="message-box action-message-box border p-3">
                            <?php # メッセージエリア ?>
                            <?php foreach($messages as $key => list($msg, $status, $auto)): ?>
                                <?php $class = $key === $global_responses->getMessageFirstKey() ? 'active' : ''; ?>
                                <?php $last_class = $key === $global_responses->getMessageLastKey() ? 'last-message' : ''; ?>
                                <p class="result-message <?=$class?> <?=$last_class?> <?=$status ?? ''?>"
                                    data-action='<?=$responses[$status]['action'] ?? ''?>'
                                    data-target='<?=$responses[$status]['target'] ?? ''?>'
                                    data-param='<?=$responses[$status]['param'] ?? ''?>'
                                    data-toggle='<?=$responses[$status]['toggle'] ?? ''?>'
                                    data-auto='<?=$auto ?? ''?>'>
                                    <?=$msg?>
                                </p>
                            <?php endforeach; ?>
                            <span class="message-scroll-icon small">【CLICK】</span>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="row">
                            <div class="col-6 mb-2">
                                <?php if(friend()->checkUsedMove()): ?>
                                    <button type="button" class="btn btn-outline-light btn-block action-btn" data-toggle="modal" data-target="#select-move-modal" id="action-btn-fight">たたかう</button>
                                <?php else: ?>
                                    <form method="post">
                                        <input type="hidden" name="action" value="fight">
                                        <input type="submit" class="btn btn-outline-light btn-block action-btn" value="たたかう">
                                        <?php input_token(); ?>
                                    </form>
                                <?php endif; ?>
                            </div>
                            <div class="col-6 mb-2">
                                <button type="button" class="btn btn-outline-light btn-block action-btn" data-toggle="modal" data-target="#item-modal" id="action-btn-item">どうぐ</button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-outline-light btn-block action-btn" data-toggle="modal" data-target="#party-modal">ポケモン</button>
                            </div>
                            <div class="col-6">
                                <button type="button" name="button" class="btn btn-outline-light btn-block action-btn" data-submit_remote="run">逃げる</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <?php
    # footerの読み込み
    include($root_path.'/Resources/Partials/Layouts/Foot/footer.php');
    # モーダルの読み込み
    foreach($modals as $modal){
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
    <script src="/Assets/js/Battle/fight.js" type="text/javascript" defer></script>
    <script src="/Assets/js/Battle/message.js" type="text/javascript" defer></script>
    <script src="/Assets/js/Battle/party.js" type="text/javascript" defer></script>
    <script src="/Assets/js/Battle/library-action.js" type="text/javascript" defer></script>
</body>
</html>
