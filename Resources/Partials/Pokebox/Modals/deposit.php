<div class="modal fade" id="pokebox-deposit-modal" tabindex="-1" role="dialog" aria-labelledby="pokebox-deposit-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <figure class="text-center p-3 mb-0">
                    <img class="mb-3" id="deposit-pokemon-img" src="" alt="預けるポケモン" />
                    <p class="mb-0"><span id="deposit-pokemon-name"></span>をボックス<?=pokebox()->getSelectedBoxNumber()?>に預けますか？</p>
                </figure>
            </div>
            <div class="modal-footer justify-content-center">
                <form id="pokebox-deposit-form" method="post">
                    <?php input_token(); ?>
                    <input type="hidden" name="action" value="deposit">
                    <input type="hidden" name="pokemon_id">
                    <button type="submit" class="btn btn-sm btn-php-dark">預ける</button>
                </form>
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">やめる</button>
            </div>
        </div>
    </div>
</div>
