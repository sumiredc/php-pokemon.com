<?php foreach($controller->getPokemonList() as $key => $name): ?>
    <?php if($key === 'Mew') continue; ?>
    <!-- Modal -->
    <div class="modal fade" id="<?=$key?>-modal" tabindex="-1" role="dialog" aria-labelledby="<?=$key?>-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="<?=$key?>-modal-title">
                        <img src="/Assets/img/pokemon/dots/mini/<?=$key?>.gif" class="mb-2" alt="<?=$name?>アイコン">
                        <?=$name?>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <figure class="mt-3">
                            <img src="/Assets/img/pokemon/dots/front/<?=$key?>.gif" alt="<?=$name?>" data-toggle="modal" data-target="#<?=$key?>-modal">
                        </figure>
                        <p><span class="font-weight-bolder"><?=$name?></span>を最初のパートナーとして連れていきますか？</p>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <form action="" method="post">
                        <input type="hidden" name="action" value="select_pokemon">
                        <input type="hidden" name="pokemon" value="<?=$key?>">
                        <div class="row">
                            <div class="col-6">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">もう少し考える</button>
                            </div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-success">キミに決めた！</button>
                            </div>
                        </div>
                        <?php input_token(); ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
