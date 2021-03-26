<!-- Modal -->
<div class="modal fade" id="pokebox-receive-modal" tabindex="-1" role="dialog" aria-labelledby="pokebox-receive-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <figure class="text-center p-3 mb-0">
                    <img class="mb-3" id="receive-pokemon-img" src="" alt="連れて行くポケモン" />
                    <p class="mb-0"><span id="receive-pokemon-name"></span>を連れて行きますか？</p>
                </figure>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">やめる</button>
                <form id="pokebox-receive-form" method="post">
                    <?php input_token(); ?>
                    <input type="hidden" name="action" value="receive">
                    <input type="hidden" name="pokemon_id">
                    <button type="submit" class="btn btn-sm btn-php-dark">連れて行く</button>
                </form>
            </div>
        </div>
    </div>
</div>
