<?php foreach(config('const.first_pokemon') as $order => $pokemon): ?>
    <div class="modal fade" id="first-pokemon-<?=$pokemon?>-modal" tabindex="-1" role="dialog" aria-labelledby="<?=$key?>-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center">
                        <figure class="my-3">
                            <img src="<?=base64_pokemon($pokemon)?>" alt="<?=$pokemon::NAME?>" class="mb-4">
                            <p class="mb-0"><span class="font-weight-bolder"><?=$pokemon::NAME?></span>を最初のパートナーとして連れていきますか？</p>
                        </figure>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <form id="first-pokemon-<?=$pokemon?>-form" method="post">
                        <input type="hidden" name="action" value="select_pokemon">
                        <input type="hidden" name="pokemon" value="<?=$order?>">
                        <input type="hidden" name="name">
                        <button type="button" class="btn btn-sm btn-secondary mr-2" data-dismiss="modal">もう少し考える</button>
                        <button type="submit" class="btn btn-sm btn-php-dark">キミに決めた！</button>
                        <?php input_token(); ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
