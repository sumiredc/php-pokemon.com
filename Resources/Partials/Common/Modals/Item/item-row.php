<?php # 利用可能 ?>
<tr data-category="<?=$category?>"
    data-target="<?=$item['class']::TARGET?>"
    data-use="<?=var_export($item['class']::allowUsed(getPageName()), true)?>"
    data-trash="<?=var_export($item['class']::allowTrashed(), true)?>"
    data-owned="<?=$item['count']?>"
    data-order="<?=$item['order']?>"
    <?php # わざマシンでは名称横に技名・説明文には技説明を使用する ?>
    <?php if($category === 'machine'): ?>
        data-description="<?=constant($item['class']::MOVE.'::DESCRIPTION')?>"
        data-name="<?=$item['class']::NAME.'（'.constant($item['class']::MOVE.'::NAME').'）'?>"
    <?php else: ?>
        data-description="<?=$item['class']::DESCRIPTION?>"
        data-name="<?=$item['class']::NAME?>"
    <?php endif; ?>
    <?php # 使用できるポケモン ?>
    <?php if(!empty($item['class']::getUsePokemon())): ?>
        data-pokemon='<?=json_encode($item['class']::getUsePokemon())?>'
    <?php endif; ?>
    class="item-row">
    <td class="w-75">
        <img src="/Assets/img/item/class/<?=$item['class']?>.png" alt="<?=$item['class']::NAME?>" class="mr-1" />
        <?=$item['class']::NAME?>
    </td>
    <td class="w-25 text-right"><?=$item['count']?> 個</td>
</tr>
