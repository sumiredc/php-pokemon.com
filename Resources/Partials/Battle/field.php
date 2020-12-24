<?php
$before_friend = battle_state()->getBefore('friend');
$before_enemy = battle_state()->getBefore('enemy');
?>
<section id="battle-field" class="p-1 p-sm-3 border-bottom">
    <div class="row mb-3 mb-sm-5 py-3 py-sm-4">
        <?php # 敵ポケモン詳細 ?>
        <div class="col-6 position-relative">
            <div id="enemy-pokemon-parameter" class="<?php if((response()->getResponse('battle-start') && battle_state()->isMode('trainer')) || $before_enemy->isFainting()) echo 'opacity-0'; ?>">
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
            <?php # トレーナー戦（ポケモンの所有数） ?>
            <?php if(battle_state()->isMode('trainer')): ?>
                <div id="enemy-trainer-parameter" class="border-bottom p-2 <?php if(!response()->getResponse('battle-start')) echo 'd-soft-none' ?>">
                    <div class="d-flex justify-content-end">
                        <?php # 空き枠 ?>
                        <?php for($i=0;$i<trainer()->getPartyEmptyCount();$i++): ?>
                            <span class="icon-party-ball empty"></span>
                        <?php endfor; ?>
                        <?php # 所有数 ?>
                        <?php for($i=0;$i<trainer()->getPartyCount();$i++): ?>
                            <span class="icon-party-ball"></span>
                        <?php endfor; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-6">
            <?php # ポケモン画像 ?>
            <figure class="mb-0 position-relative" style="height:80px;">
                <input type="image"
                id="enemy-pokemon-image"
                class="action-img-btn <?php if($before_enemy->isFainting() || (battle_state()->isMode('trainer') && response()->getResponse('battle-start'))) echo 'opacity-0'; ?>"
                src="<?=$before_enemy->base64('front', true)?>"
                alt="<?=$before_enemy::NAME?>"
                data-toggle="modal"
                data-target="#enemy-battle-state-modal" />
                <?php # トレーナー戦（トレーナー画像） ?>
                <?php if(battle_state()->isMode('trainer')): ?>
                    <img src="/Assets/img/npc/front/<?=trainer()->getCategory()?>.gif"
                    id="enemy-trainer-image"
                    class="<?php if(!response()->getResponse('battle-start')) echo 'd-soft-none' ?>"
                    alt="<?=trainer()->getCategoryName()?>" />
                <?php endif; ?>
            </figure>
        </div>
    </div>
    <div class="row py-3 py-sm-4">
        <?php # 自ポケモン詳細 ?>
        <div class="col-6">
            <figure class="mb-0 position-relative" style="height:80px;">
                <input type="image"
                id="friend-pokemon-image"
                class="action-img-btn <?php if(response()->getResponse('battle-start') || $before_friend->isFainting()) echo 'opacity-0'; ?>"
                src="<?=$before_friend->base64('back', true)?>"
                alt="<?=$before_friend::NAME?>"
                data-toggle="modal"
                data-target="#friend-battle-state-modal" />
            </figure>
        </div>
        <div class="col-6">
            <div id="friend-pokemon-parameter" class="<?php if(response()->getResponse('battle-start') || $before_friend->isFainting()) echo 'opacity-0'; ?>">
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
    </div>
</section>
