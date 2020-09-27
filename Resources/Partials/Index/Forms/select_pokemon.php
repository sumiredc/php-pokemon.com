<form action="" method="post">
    <p>ポケモンを選択してください</p>
    <div class="input-group">
        <select class="form-control" id="select_pokemon" name="pokemon">
            <option value="">--選択してください--</option>
            <?php foreach($controller->getPokemonList() as $class => $pokemon): ?>
                <option value="<?=$class?>"><?=$pokemon?></option>
            <?php endforeach; ?>
        </select>
        <div class="input-group-append">
            <button type="submit" class="btn btn-primary">君に決めた！</button>
        </div>
    </div>
</form>
