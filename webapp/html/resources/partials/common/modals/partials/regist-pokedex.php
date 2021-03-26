<div class="modal fade" id="<?=$modal['id']?>-modal" tabindex="-1" role="dialog" aria-labelledby="<?=$modal['id']?>-modal-title" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="theme-back mb-3 p-3 rounded">
                    <figure class="d-flex justify-content-around align-items-center mb-3 py-3">
                        <img src="<?=base64_pokemon($modal['pokemon'])?>" alt="ポケモン-前">
                        <img src="<?=base64_pokemon($modal['pokemon'], 'back')?>" alt="ポケモン-後ろ">
                    </figure>
                    <div class="bg-php-back rounded p-2">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <label class="font-weight-bold mb-2">名称</label>：<?=$modal['pokemon']::NAME?>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="font-weight-bold mb-2">分類</label>：<?=$modal['pokemon']::SPECIES?>
                            </div>
                            <div class="col-12">
                                <p class="mb-0"><?=$modal['pokemon']::DESCRIPTION?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" data-controls="message-box">閉じる</button>
            </div>
        </div>
    </div>
</div>
