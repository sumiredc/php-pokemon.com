<form action="" method="post" id="fight-form">
    <input type="hidden" name="action" value="fight">
    <input type="hidden" name="param" id="fight-form-param">
    <div class="input-group mb-3">
        <table class="table table-bordered table-hover table-sm mb-3" id="move-table">
            <thead class="thead-light">
                <tr>
                    <th scope="col">使える技</th>
                    <th scope="col">タイプ</th>
                    <th scope="col">PP</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($pokemon->getMove() as $key => $move): ?>
                    <tr class="move-table-row" data-key="<?=$key?>">
                        <th scope="row" class="w-50"><?=$move['class']->getName()?></th>
                        <td><?=$move['class']->getType()->getName()?></td>
                        <td><?=$move['remaining']?>/<?=$move['class']->getPp($move['correction'])?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php input_token(); ?>
</form>
