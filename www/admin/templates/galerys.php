<?php defined('WOOD') or die('Access denied'); ?>
<div class="content">
	<h2>Список галерей</h2>
<?php
if(isset($_SESSION['answer'])){
    echo $_SESSION['answer'];
    unset($_SESSION['answer']);
}
?>
	<a href="?view=add_galery"><img class="add_some" src="<?=ADMIN_TEMPLATE?>images/add_galery.jpg" alt="добавить страницу" /></a>
	<table class="tabl" cellspacing="1">
	  <tr class="no_sort">
		<th class="number">№</th>
		<th class="str_name">Название галереи</th>
		<th class="str_sort">Сортировка</th>
		<th class="str_action">Действие</th>
	  </tr>
<?php $i = 1; ?>
<?php foreach($galerys as $item): ?>
<tr id="<?=$item['galery_id'];?>">
	<td class="position" style="width:25px"><?=$item['galery_id']?></td>
	<td style="width:360px" class="name_page"><a href="?view=edit_galery&amp;galery_id=<?=$item['galery_id']?>"><?=$item['galery_nam']?></a></td>
	<td class="position" style="width:80px"><?=$item['position']?></td>
	<td style="width:160px"><a href="?view=edit_galery&amp;galery_id=<?=$item['galery_id']?>" class="edit">изменить</a>&nbsp; | &nbsp;<a href="?view=del_galery&amp;galery_id=<?=$item['galery_id']?>" class="del">удалить</a></td>
</tr>
<?php $i++; ?>
<?php endforeach; ?>      
	</table>
	<a href="?view=add_galery"><img class="add_some" src="<?=ADMIN_TEMPLATE?>images/add_galery.jpg" alt="добавить страницу" /></a>

	</div> <!-- .content -->
<div class="load"></div> <!-- .load -->
<div class="res"></div> <!-- .res -->
	</div> <!-- .content-main -->
</div> <!-- .karkas -->
</body>
</html>