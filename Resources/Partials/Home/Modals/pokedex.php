<div class="modal fade" id="pokedex-modal" tabindex="-1" role="dialog" aria-labelledby="pokedex-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pokedex-modal-title">
                    <img src="/Assets/img/icon/pokedex.png" class="mr-2" alt="ポケモン図鑑" style="max-height:18px;" />
                    ポケモン図鑑
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-php-back">
                <div class="row">
                    <div class="col-6">
                        <label class="font-weight-bold mb-0">見つけた数</label>：<?=player()->pokedex()->getCount(1)?>
                    </div>
                    <div class="col-6">
                        <label class="font-weight-bold mb-0">捕まえた数</label>：<?=player()->pokedex()->getCount(2)?>
                    </div>
                </div>
                <hr>
                <div class="theme-back mb-3 p-3 rounded" id="pokedex-preview">
                    <figure class="d-flex justify-content-around align-items-center mb-0" style="min-height:120px;">
                        <img src="" alt="ポケモン-前" class="d-soft-none" data-pokemon="image-front">
                        <img src="" alt="ポケモン-後ろ" class="d-soft-none" data-pokemon="image-back">
                    </figure>
                    <div class="bg-php-back rounded p-2">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <label class="font-weight-bold mb-2">名称</label>：<span data-pokemon="name"></span>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="font-weight-bold mb-2">分類</label>：<span data-pokemon="species"></span>
                            </div>
                            <div class="col-12">
                                <p class="mb-0" style="min-height:48px;" data-pokemon="description"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="overflow-auto" style="max-height:200px;">
                    <table class="table table-sm table-bordered table-selected table-hover bg-white mb-0" id="pokedex-list-table">
                        <tbody>
                            <?php foreach(player()->pokedex()->getPokedex(true) as $number => list($class, $name, $species, $desc)): ?>
                                <tr data-class="<?=$class?>" data-name="<?=$name?>" data-species="<?=$species?>" data-description="<?=$desc?>">
                                    <th scope="row" style="width:20px;">
                                        <?php $registed = player()->pokedex()->isRegisted($number); ?>
                                        <?php if($registed >= 2): # 捕まえた ?>
                                            <img src="/Assets/img/icon/pokemon.png" alt="捕まえた" style="max-height: 16px;" data-registed="true">
                                        <?php elseif($registed === 1): # 見つけた ?>
                                            <input type="hidden" data-registed="true">
                                        <?php else: # 未発見 ?>
                                            <input type="hidden" data-registed="false">
                                        <?php endif; ?>
                                    </th>
                                    <td style="width:60px;"><?=fillZero($number)?></td>
                                    <td><?=$name?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
