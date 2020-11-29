<?php foreach($controller->getPokemonList() as $key => $name): ?>
    <!-- Modal -->
    <div class="modal fade" id="<?=$key?>-modal" tabindex="-1" role="dialog" aria-labelledby="<?=$key?>-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center">
                        <figure class="my-3">
                            <img src="/Assets/img/pokemon/dots/front/<?=$key?>.gif" alt="<?=$name?>" class="mb-4">
                            <p class="mb-0"><span class="font-weight-bolder"><?=$name?></span>を最初のパートナーとして連れていきますか？</p>
                        </figure>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <form action="" id="<?=$key?>-form" method="post">
                        <input type="hidden" name="action" value="select_pokemon">
                        <input type="hidden" name="pokemon" value="<?=$key?>">
                        <input type="hidden" name="name">
                        <div class="row">
                            <div class="col-6">
                                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">もう少し考える</button>
                            </div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-sm btn-php-dark" data-form="#<?=$key?>-form">キミに決めた！</button>
                            </div>
                        </div>
                        <?php input_token(); ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
