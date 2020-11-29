<?php if(count(pokebox()->getPokebox()) < 10): ?>
    <button type="button" class="btn btn-sm btn-php-dark mx-1" data-submit_remote="add_box">ボックス追加</button>
<?php endif; ?>
<?php # 共通 ?>
<button type="button" class="btn btn-sm btn-disabled mx-1" data-category="common" data-btn="default" disabled>様子を見る</button>
<?php foreach(array_merge(player()->getParty(), pokebox()->accessSelectedBox()) as $pokemon): ?>
    <button type="button" class="btn btn-sm btn-php-dark d-soft-none mx-1" data-category="common" data-btn="details" data-pokemon_id="<?=$pokemon->getId()?>" data-toggle="modal" data-target="#pokemon<?=$pokemon->getId()?>-details-modal">様子を見る</button>
    <?php
    # 詳細モーダルの読み込み
    include($root_path.'/Resources/Partials/Common/Modals/pokemon-details.php');
    ?>
<?php endforeach; ?>
<?php # パーティー用のボタン ?>
<button type="button" class="btn btn-sm btn-disabled mx-1 d-soft-none" data-category="party" data-btn="default" disabled>預ける</button>
<button type="button" class="btn btn-sm btn-php-dark mx-1 d-soft-none" data-category="party" data-btn="deposit" data-target="#pokebox-deposit-modal" data-toggle="modal">預ける</button>
<?php # ボックス移動ボタン ?>
<button type="button" class="btn btn-sm btn-disabled mx-1" data-category="pokebox" data-btn="default" disabled>連れて行く</button>
<button type="button" class="btn btn-sm btn-php-dark mx-1 d-soft-none" data-category="pokebox" data-btn="receive" data-target="#pokebox-receive-modal" data-toggle="modal">連れて行く</button>
