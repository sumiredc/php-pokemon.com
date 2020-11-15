<!-- Modal -->
<?php $bag = $player->getBag(); ?>
<div class="modal fade" id="item-modal" tabindex="-1" role="dialog" aria-labelledby="item-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="item-modal-title">どうぐ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body my-2">
                <?php # タブ ?>
                <nav class="nav nav-pills nav-justified btn-group mb-3" id="item-modal-tab">
                    <?php $cnt = 0; ?>
                    <?php foreach($bag as $category => $items): ?>
                        <a class="btn btn-outline-secondary nav-item nav-link <?php if(!$cnt) echo 'active'; ?>" id="item-modal-<?=$category?>-tab" data-toggle="tab" href="#item-modal-<?=$category?>" role="tab" aria-controls="item-modal-<?=$category?>" aria-selected="true">
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
                            <h6 class="font-weight-bolder mb-2"><?=transJp($category, 'item');?></h6>
                            <div class="bg-light p-3 mb-2 overflow-auto" style="height:120px;">
                                <h6 id="item-modal-<?=$category?>-name" class="font-weight-bolder"></h6>
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
                                                <tr data-description="<?=$item['item']->getDescription()?>"
                                                    data-name="<?=$item['item']->getName()?>"
                                                    data-category="<?=$category?>"
                                                    class="item-row">
                                                    <td class="w-75">
                                                        <img src="/Assets/img/item/class/<?=get_class($item['item'])?>.png" alt="<?=$item['item']->getName()?>" class="mr-1" />
                                                        <?=$item['item']->getName()?>
                                                    </td>
                                                    <td class="w-25 text-right"><?=$item['count']?> 個</td>
                                                </tr>
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
