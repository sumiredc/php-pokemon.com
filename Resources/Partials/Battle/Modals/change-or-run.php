<!-- Modal -->
<div class="modal fade" id="<?=$modal['id']?>-modal" tabindex="-1" role="dialog" aria-labelledby="<?=$modal['id']?>-modal-title" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p class="mb-0">次のポケモンを選びますか？</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#party-modal">ポケモンを選ぶ</button>
                <button type="button" class="btn btn-sm btn-danger" data-submit_remote="run">逃げる</button>
            </div>
        </div>
    </div>
</div>
