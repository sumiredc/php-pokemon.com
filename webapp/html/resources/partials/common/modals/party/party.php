<?php $static = response()->isForceModalTarget('#party-modal'); ?>
<div class="modal fade" id="party-modal" tabindex="-1" role="dialog" aria-labelledby="party-modal-title" aria-hidden="true" <?php if($static) echo 'data-keyboard="false" data-backdrop="static"'; ?>>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="party-modal-title">
                    <img src="/assets/img/icon/pokemon.png" alt="ポケモン" />
                    ポケモン
                </h5>
                <?php if(!$static): ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                <?php endif; ?>
            </div>
            <div class="modal-body table-selected py-0" data-list="party">
                <?php foreach(player()->getParty() as $order => $party): ?>
                    <?php if(getPageName() === 'battle'): ?>
                        <?php # バトル画面用 ?>
                        <div class="row py-2 bg-hover-light table-selected-row" data-order="<?=$order?>" data-fight="<?=var_export($party->isFight(), true)?>">
                        <?php else: ?>
                            <?php # バトル画面以外 ?>
                            <div class="row py-2 bg-hover-light"
                            data-toggle="modal"
                            data-dubble_modal="true"
                            data-target="#pokemon<?=$party->getId()?>-details-modal"
                            data-order="<?=$order?>">
                        <?php endif; ?>
                        <div class="col-3 text-center">
                            <img src="<?=$party->base64('mini')?>" alt="<?=$party::NAME?>">
                        </div>
                        <div class="col-9">
                            <div class="row">
                                <div class="col-12">
                                    <?=$party->getNickname()?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-10">
                                    <div class="progress rounded-pill bg-gray" style="height:4px;">
                                        <div class="progress-bar bg-<?=$party->getRemainingHp('color')?>"
                                            role="progressbar"
                                            style="width:<?=$party->getRemainingHp('per')?>%;"
                                            aria-valuenow="<?=$party->getRemainingHp()?>"
                                            aria-valuemin="0"
                                            aria-valuemax="<?=$party->getStats('H')?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    <?=$party->getRemainingHp()?> / <?=$party->getStats('H')?>
                                </div>
                                <div class="col-4">
                                    Lv.<?=$party->getLevel()?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php # フッター（ホーム画面のみ） ?>
            <?php if(getPageName() === 'home'): ?>
                <div class="modal-footer justify-content-between">
                    <p class="mb-0 small text-white">ドラッグで並び替えができます</p>
                    <form id="party-order-sort-form" method="post">
                        <input type="hidden" name="action" value="sort_party">
                        <input type="hidden" name="orders" value=''>
                        <?php input_token(); ?>
                        <button type="submit" class="btn btn-sm btn-disabled" disabled>並び替え</button>
                    </form>
                </div>
            <?php endif; ?>
            <?php # フッター（バトル画面） ?>
            <?php if(getPageName() === 'battle'): ?>
                <div class="modal-footer">
                    <?php foreach(player()->getParty() as $order => $party): ?>
                        <button class="btn btn-sm btn-php-dark"
                        data-action="details"
                        data-toggle="modal"
                        data-dubble_modal="true"
                        data-target="#pokemon<?=$party->getId()?>-details-modal"
                        data-order="<?=$order?>"
                        style="display:none;">
                        様子を見る</button>
                    <?php endforeach; ?>
                    <button class="btn btn-sm btn-disabled" data-btn="default" data-action="details" disabled>様子を見る</button>
                    <form id="partner-change-form" method="post">
                        <?php input_token(); ?>
                        <input type="hidden" name="action" value="change">
                        <input type="hidden" name="order">
                        <button type="submit" class="btn btn-sm btn-disabled" data-selected="<?=battle_state()->getOrder()?>" disabled>入れ替える</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php
// 詳細モーダル
foreach(player()->getParty() as $pokemon){
    include resources_path('partials/common/modals/pokemon-details.php');
}
?>
