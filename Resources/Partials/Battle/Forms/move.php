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
                <?php foreach($pokemon->getMove() as $move): ?>
                    <tr class="move-table-row" data-move_class="<?=get_class($move)?>">
                        <th scope="row" class="w-50"><?=$move->getName()?></th>
                        <td><?=$move->getType()->getName()?></td>
                        <td><?=$move->getPp()?>/<?=$move->getPp()?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</form>
