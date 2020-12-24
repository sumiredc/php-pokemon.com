<!-- Modal -->
<?php $bag = player()->getBag(); ?>
<div class="modal fade" id="item-modal" tabindex="-1" role="dialog" aria-labelledby="item-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="item-modal-title">
                    <img src="/Assets/img/icon/bag.png" alt="どうぐ" />
                    どうぐ
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body my-2">
                <?php # タブ ?>
                <nav class="nav nav-pills nav-justified btn-group mb-3" id="item-modal-tab">
                    <?php $cnt = 0; ?>
                    <?php foreach($bag as $category => $items): ?>
                        <a class="btn btn-outline-php-dark nav-item nav-link <?php if(!$cnt) echo 'active'; ?>" id="item-modal-<?=$category?>-tab" data-toggle="tab" href="#item-modal-<?=$category?>" role="tab" aria-controls="item-modal-<?=$category?>" aria-selected="true">
                            <img src="/Assets/img/item/category/<?=$category?>.png" alt="<?=transJp($category, 'item');?>">
                        </a>
                        <?php $cnt++; ?>
                    <?php endforeach; ?>
                </nav>
                <?php # コンテンツ ?>
                <div class="tab-content" id="item-modal-tab-content">
                    <?php $cnt = 0; ?>
                    <?php foreach($bag as $category => $items): ?>
                        <div class="tab-pane fade show <?php if(!$cnt) echo 'active'; ?>" id="item-modal-<?=$category?>" role="tabpanel" aria-labelledby="item-modal-<?=$category?>">
                            <div class="bg-light p-3 mb-2 overflow-auto" style="height:120px;">
                                <div class="d-flex justify-content-between">
                                    <h6 id="item-modal-<?=$category?>-name" class="font-weight-bolder mb-0 d-flex align-self-center"></h6>
                                    <div class="item-action-button-group" data-category="<?=$category?>">
                                        <?php # プレイヤー対象のアイテム使用 ?>
                                        <form method="post" data-button="use" data-item_target="player" style="display:none">
                                            <?php input_token(); ?>
                                            <input type="hidden" name="action" value="item">
                                            <input type="hidden" name="order">
                                            <button type="submit" class="btn btn-sm btn-php-dark">使う</button>
                                        </form>
                                        <?php # 敵ポケモン対象のアイテム使用 ?>
                                        <form method="post" data-button="use" data-item_target="enemy" style="display:none">
                                            <?php input_token(); ?>
                                            <input type="hidden" name="action" value="item">
                                            <input type="hidden" name="order">
                                            <button type="submit" class="btn btn-sm btn-php-dark">使う</button>
                                        </form>
                                        <?php # 味方ポケモン対象のアイテム使用 ?>
                                        <button type="button" class="btn btn-sm btn-php-dark" data-button="use" data-item_target="friend" data-toggle="modal" data-target="#item-use-friend-modal" style="display:none">使う</button>
                                        <?php # バトル中の味方ポケモン対象のアイテム使用 ?>
                                        <form method="post" data-button="use" data-item_target="friend_battle" style="display:none">
                                            <?php input_token(); ?>
                                            <input type="hidden" name="action" value="item">
                                            <input type="hidden" name="order">
                                            <button type="submit" class="btn btn-sm btn-php-dark">使う</button>
                                        </form>
                                        <?php # 捨てる ?>
                                        <?php if(getPageName() !== 'battle'): ?>
                                            <button type="button" class="btn btn-sm btn-danger" data-button="trash" data-toggle="modal" data-target="#item-trash-modal" style="display:none">捨てる</button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <hr>
                                <p class="mb-0 small" id="item-modal-<?=$category?>-description"></p>
                            </div>
                            <div class="bg-light p-3 overflow-auto" style="height:300px;">
                                <?php if(empty($items)): ?>
                                    <p class="mb-0">１つも持っていません</p>
                                <?php else: ?>
                                    <table class="table table-sm table-hover table-selected table-bordered bg-white mb-0">
                                        <tbody>
                                            <?php foreach($items as $item): ?>
                                                <?php if(getPageName() === 'battle'): ?>
                                                    <?php include(resources_path('Partials/Common/Modals/Item/').'item-row-battle.php'); ?>
                                                <?php else: ?>
                                                    <?php include(resources_path('Partials/Common/Modals/Item/').'item-row.php'); ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php $cnt++; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
