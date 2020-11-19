<!-- Modal -->
<div class="modal fade" id="shop-modal" tabindex="-1" role="dialog" aria-labelledby="shop-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shop-modal-title">フレンドリィショップ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php # ナビ ?>
                <nav class="nav nav-pills nav-justified btn-group mb-3" id="shop-modal-tab">
                    <a class="btn btn-outline-success nav-item nav-link active" id="shop-modal-buy-tab" data-toggle="tab" href="#shop-modal-buy" role="tab" aria-controls="shop-modal-buy" aria-selected="true" data-type="buy">購入</a>
                    <a class="btn btn-outline-info nav-item nav-link" id="shop-modal-sell-tab" data-toggle="tab" href="#shop-modal-sell" role="tab" aria-controls="shop-modal-sell" aria-selected="true" data-type="sell">売却</a>
                </nav>
                <?php # 購入 ?>
                <div class="tab-content mb-3" id="shop-modal-tab-content">
                    <div class="tab-pane fade show active" id="shop-modal-buy" role="tabpanel" aria-labelledby="shop-modal-buy-tab">
                        <?php
                        $color = 'success';
                        $form = 'buy';
                        $select = $controller->getShop();
                        include($root_path.'/Resources/Partials/Home/Forms/shop.php');
                        ?>
                    </div><!-- buy -->
                    <?php # 売却 ?>
                    <div class="tab-pane fade show" id="shop-modal-sell" role="tabpanel" aria-labelledby="shop-modal-sell-tab">
                        <?php
                        $color = 'info';
                        $form = 'sell';
                        $select = player()->getBag();
                        include($root_path.'/Resources/Partials/Home/Forms/shop.php');
                        ?>
                    </div><!-- sell -->
                </div>
                <input type="hidden" id="player-remaining-money" value="<?=player()->getMoney()?>">
            </div><!-- Modal body -->
        </div><!-- Modal content -->
    </div><!-- Modal dialog -->
</div><!-- Modal  -->
