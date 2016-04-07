<?php if($products): ?>
<table class="tabl" cellspacing="1" align="center">
	<tr>
		<th class="number"></th>
		<th class="number">№</th>
		<th class="str_name" style="width:280px;">Наименование</th>
		<th class="str_sort">Дата</th>
		<th class="str_action">Действия</th>
	</tr>
<?php foreach($products as $item): ?>
<tr id ="tr_<?=htmlspecialchars($item['goods_id'])?>">
	<td><img src='<?=$item['pic']?>' width="90" height="90"></td>
	<td><?=htmlspecialchars($item['goods_id'])?></td>
	<td class="name_page"><?=htmlspecialchars($item['name'])?></td>
	<td><?=$item['date']?></td>
	<td>
		<a href="?view=user/shop/edit_product&amp;goods_id=<?=$item['goods_id']?>" class="edit">Редактировать</a><br />
		<a href="#" rel="<?=$item['goods_id']?>" class="del_tovar">Удалить</a>
	</td>
</tr>
<?php endforeach; ?>
</table>
<?php if($pages_count > 1) pagination($page, $pages_count, $modrew = 0); ?>
<?php else: ?>
<div class="error">Нет товаров</div>
<?php endif; ?>
