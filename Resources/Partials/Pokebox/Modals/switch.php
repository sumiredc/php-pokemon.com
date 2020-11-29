<!-- Modal -->
<div class="modal fade" id="pokebox-switch-modal" tabindex="-1" role="dialog" aria-labelledby="pokebox-switch-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <figure class="text-center p-3 mb-0">
                    <p class="mb-0"><span id="switch-pokebox-name"></span>に切り替えても良いですか？</p>
                </figure>
            </div>
            <div class="modal-footer justify-content-center">
                <form id="pokebox-switch-form" method="post">
                    <?php input_token(); ?>
                    <input type="hidden" name="action" value="switch">
                    <input type="hidden" name="box">
                    <button type="submit" class="btn btn-sm btn-php-dark">切り替える</button>
                </form>
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">やめる</button>
            </div>
        </div>
    </div>
</div>
