<?php
$before_friend = battle_state()->getBefore('friend');
$before_enemy = battle_state()->getBefore('enemy');
?>
<section id="battle-field" class="p-1 p-sm-3 border-bottom">
    <div class="row mb-3 mb-sm-5 py-3 py-sm-4">
        <?php # 敵ポケモン詳細 ?>
        <div class="col-6 <?php if($before_enemy->isFainting()) echo 'opacity-0'; ?>" id="enemy-pokemon-parameter">
            <p>
                <span class="mr-2" id="name-enemy"><?=$before_enemy->getNickName()?></span>
                <span class="mr-2">Lv:<span id="level-enemy"><?=$before_enemy->getLevel()?></span></span>
                <span class="mr-2 badge badge-<?=$before_enemy->getSaColor(false)?>" id="sa-enemy">
                    <?=$before_enemy->getSaName(false)?>
                </span>
            </p>
            <div class="form-group">
                <div class="progress rounded-pill bg-gray" style="height:12px;">
                    <div id="hpbar-enemy"
                    class="progress-bar bg-success"
                    role="progressbar"
                    style="width:<?=$before_enemy->getRemainingHp('per')?>%;"
                    aria-valuenow="<?=$before_enemy->getRemainingHp()?>"
                    aria-valuemin="0"
                    aria-valuemax="<?=$before_enemy->getStats('H')?>"></div>
                </div>
            </div>
        </div>
        <div class="col-6 text-center">
            <input type="image"
            id="enemy-pokemon-image"
            class="action-img-btn <?php if($before_enemy->isFainting()) echo 'opacity-0'; ?>"
            src="/Assets/img/pokemon/dots/front/<?=$before_enemy->getImage()?>.gif"
            alt="<?=$before_enemy::NAME?>"
            data-pokemon="<?=get_class($before_enemy)?>"
            data-toggle="modal"
            data-target="#enemy-battle-state-modal" />
        </div>
    </div>
    <div class="row py-3 py-sm-4">
        <?php # 自ポケモン詳細 ?>
        <div class="col-6 text-center">
            <input type="image"
            id="friend-pokemon-image"
            class="action-img-btn <?php if(response()->getResponse('battle-start') || $before_friend->isFainting()) echo 'opacity-0'; ?>"
            src="/Assets/img/pokemon/dots/back/<?=$before_friend->getImage()?>.gif"
            alt="<?=$before_friend::NAME?>"
            data-pokemon="<?=get_class($before_friend)?>"
            data-toggle="modal"
            data-target="#friend-battle-state-modal" />
        </div>
        <div class="col-6 <?php if(response()->getResponse('battle-start') || $before_friend->isFainting()) echo 'opacity-0'; ?>" id="friend-pokemon-parameter">
            <p>
                <span class="mr-2" id="name-friend"><?=$before_friend->getNickName()?></span>
                <span class="mr-2">Lv:<span id="level-friend"><?=$before_friend->getLevel()?></span></span>
                <span class="mr-2 badge badge-<?=$before_friend->getSaColor(false)?>" id="sa-friend">
                    <?=$before_friend->getSaName(false)?>
                </span>
            </p>
            <div class="form-group">
                <div class="progress rounded-pill bg-gray" style="height:12px;">
                    <div id="hpbar-friend"
                    class="progress-bar bg-<?=$before_friend->getRemainingHp('color')?>"
                    role="progressbar"
                    style="width:<?=$before_friend->getRemainingHp('per')?>%;"
                    aria-valuenow="<?=$before_friend->getRemainingHp()?>"
                    aria-valuemin="0"
                    aria-valuemax="<?=$before_friend->getStats('H')?>"></div>
                </div>
                <p class="text-right px-3">
                    <span id="remaining-hp-count-friend"><?=$before_friend->getRemainingHp()?></span>
                    / <span id="max-hp-count-friend"><?=$before_friend->getStats('H')?></span>
                </p>
                <?php # 経験値バー ?>
                <div class="progress rounded-pill bg-gray" style="height:4px;">
                    <div id="expbar-friend"
                    class="progress-bar bg-primary"
                    role="progressbar"
                    style="width:<?=$before_friend->getPerCompNexExp()?>%;"
                    aria-valuenow="<?=$before_friend->getPerCompNexExp()?>"
                    aria-valuemin="0"
                    aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
</section>
