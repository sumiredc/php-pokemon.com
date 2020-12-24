<?php # バトル中のアイテム欄 ?>
<?php # 利用不可 ?>
<?php if(!in_array('battle', $item['class']::TIMING, true)): ?>
    <?php # 利用不可 ?>
    <tr class="text-muted">
    <td class="w-75">
        <img src="/Assets/img/item/class/<?=$item['class']?>.png" alt="<?=$item['class']::NAME?>" class="mr-1" />
        <?=$item['class']::NAME?>
    </td>
        <td class="w-25 text-right"><?=$item['count']?> 個</td>
    </tr>
<?php else: ?>
    <?php # 利用可能 ?>
    <?php include(resources_path('Partials/Common/Modals/Item/').'item-row.php'); ?>
<?php endif; ?>
