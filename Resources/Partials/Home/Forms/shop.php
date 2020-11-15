<form method="post" data-form="shop">
    <?php input_token(); ?>
    <input type="hidden" name="action" value="shop">
    <input type="hidden" name="do" value="<?=$form?>">
    <div class="mb-3 p-3 bg-light">
        <div class="input-group">
            <select class="custom-select col-8" name="order" data-form="<?=$form?>">
                <option value="" selected>----</option>
                <?php foreach($select as $category_group => $items): ?>
                    <optgroup label="<?=transJp($category_group, 'item')?>">
                        <?php # optionの生成 ?>
                        <?php foreach($items as $item): ?>
                            <?php # 取得する価格の分岐 ?>
                            <?php if($form === 'buy') $price = $item['item']->getBidPrice(); ?>
                            <?php if($form === 'sell') $price = $item['item']->getSellPrice(); ?>
                            <?php if(is_null($price)) continue; ?>
                            <option value="<?=$item['order']?>"
                                data-price="<?=$price?>"
                                data-item="<?=$item['item']->getName()?>"
                                data-max="<?=$item['item']->getMax()?>"
                                data-owned="<?=$item['owned'] ?? $item['count']?>">
                                <?=$item['item']->getName()?>（<?=$price?>円）
                            </option>
                        <?php endforeach; ?>
                    </optgroup>
                <?php endforeach; ?>
            </select>
            <select class="custom-select col-4" name="count" data-form="<?=$form?>">
                <option value="">----</option>
            </select>
        </div>
    </div>
    <div class="alert alert-<?=$color?>" id="shop-<?=$form?>-calculator" role="alert">
        <div class="form-group row">
            <label class="col-3 col-form-label">おこづかい</label>
            <div class="col-9 text-right">
                <p class="form-control-plaintext">
                    <span class='mr-2'><?=$player->getMoney()?></span>円
                </p>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <label class="col-3 col-form-label">所有数</label>
            <div class="col-9 text-right">
                <p class="form-control-plaintext">
                    <span id="shop-<?=$form?>-item-owned"></span>
                </p>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <label class="col-3 col-form-label">内訳</label>
            <div class="col-3 text-right">
                <p class="form-control-plaintext">
                    <span id="shop-<?=$form?>-item-name"></span>
                </p>
            </div>
            <div class="col-3 text-right">
                <p class="form-control-plaintext">
                    <span id="shop-<?=$form?>-item-price"></span>
                </p>
            </div>
            <div class="col-3 text-right">
                <p class="form-control-plaintext">
                    <span id="shop-<?=$form?>-item-count"></span>
                </p>
            </div>
        </div>
        <hr>
        <div class="form-group row mb-0">
            <label class="col-3 col-form-label">合計</label>
            <div class="col-9 text-right">
                <p class="form-control-plaintext font-weight-bolder">
                    <span id="shop-<?=$form?>-total-price" class="mr-2"></span>
                </p>
            </div>
        </div>
        <p data-alert="<?=$form?>" class="text-danger text-right mb-0 mt-2" style="display:none;">
            おこづかいが足りません
        </p>
    </div><!-- aleart -->
    <button type="submit" class="btn btn-<?=$color?> btn-block" id="shop-<?=$form?>-submit" disabled>
        <?php if($form === 'buy') echo '買う'; ?>
        <?php if($form === 'sell') echo '売る'; ?>
    </button>
</form>
