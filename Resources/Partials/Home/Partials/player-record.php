<div class="card">
    <div class="card-header bg-php d-flex justify-content-between align-items-center cursor-pointer" id="player-record-collapse-head" data-toggle="collapse" data-target="#player-record-collapse" aria-expanded="true" aria-controls="player-record-collapse">
        <h6 class="mb-0 font-weight-bold">戦績</h6>
        <i class="fas fa-bars fa-lg text-white"></i>
    </div>
    <div id="player-record-collapse" class="collapse" aria-labelledby="player-record-collapse-head" data-parent="#player-modal-accordion">
        <div class="card-body">
            <div class="form-group row">
                <label class="font-weight-bold col-12">トレーナー戦</label>
                <div class="col-6">
                    <label class="font-weight-bold small mb-1">勝ち</label>
                    <p class="form-control-plaintext bg-light rounded-sm py-1 px-2 text-right">
                        <?=player()->getCounter()['trainer']['win'] ?? 0?>回
                    </p>
                </div>
                <div class="col-6">
                    <label class="font-weight-bold small mb-1">負け</label>
                    <p class="form-control-plaintext bg-light rounded-sm py-1 px-2 text-right">
                        <?=player()->getCounter()['trainer']['lose'] ?? 0?>回
                    </p>
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <label class="font-weight-bold col-12">野生ポケモン</label>
                <div class="col-4">
                    <label class="font-weight-bold small mb-1">勝ち</label>
                    <p class="form-control-plaintext bg-light rounded-sm py-1 px-2 text-right">
                        <?=player()->getCounter()['wild']['win'] ?? 0?>回
                    </p>
                </div>
                <div class="col-4">
                    <label class="font-weight-bold small mb-1">負け</label>
                    <p class="form-control-plaintext bg-light rounded-sm py-1 px-2 text-right">
                        <?=player()->getCounter()['wild']['lose'] ?? 0?>回
                    </p>
                </div>
                <div class="col-4">
                    <label class="font-weight-bold small mb-1">逃げた回数</label>
                    <p class="form-control-plaintext bg-light rounded-sm py-1 px-2 text-right">
                        <?=player()->getCounter()['wild']['run'] ?? 0?>回
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
