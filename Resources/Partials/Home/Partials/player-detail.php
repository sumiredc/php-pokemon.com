<div class="card">
    <div class="card-header bg-php" id="player-detail-collapse-head" data-toggle="collapse" data-target="#player-detail-collapse" aria-expanded="true" aria-controls="player-detail-collapse">
        <h6 class="mb-0 font-weight-bold">
            プレイヤー情報
        </h6>
    </div>
    <div id="player-detail-collapse" class="collapse show" aria-labelledby="player-detail-collapse-head" data-parent="#player-modal-accordion">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label class="font-weight-bold mb-0">プレイヤーID</label>
                        <p class="form-control-plaintext bg-light rounded-sm py-1 px-2 cursor-pointer" data-clipboard="true" title="クリックでコピーします"><?=player()->getID()?></p>
                        <small class="form-text text-muted ml-2">クリックでコピーします</small>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label class="font-weight-bold mb-0">おこづかい</label>
                        <p class="form-control-plaintext bg-light rounded-sm py-1 px-2 text-right">
                            <?=player()->getMoney()?>円
                        </p>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label class="font-weight-bold mb-0">プレイヤーレベル</label>
                        <p class="form-control-plaintext bg-light rounded-sm py-1 px-2 text-right">
                            <?=player()->getLevel()?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
