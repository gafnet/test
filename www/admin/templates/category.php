<?php defined('WOOD') or die('Access denied'); ?>
<div class="content">
	<h2>Список категорий</h2>
<?php
if(isset($_SESSION['answer'])){
    echo $_SESSION['answer'];
    unset($_SESSION['answer']);
}
?>
	<a href="?view=add_category"><img class="add_some" src="<?=ADMIN_TEMPLATE?>images/add_kategory.jpg" alt="добавить категорию" /></a>
	<table class="tabl" cellspacing="1">
	  <tr>
		<th class="number">№</th>
		<th class="str_name">Название страницы</th>
		<th class="str_sort">Сортировка</th>
		<th class="str_action">Действие</th>
	  </tr>
<?php $i = 1; ?>
<?php print_arr($cat);?>`
<?php foreach($cat as $key => $value): ?>
<tr>
	<td><?=$i?></td>
	<td class="name_page"><?=$value[0]?></td>
	<td class="position" style="width:80px"><?//=$item['position']?></td>
	<td><a href="?view=edit_category&amp;cat_id=<?=$key?>" class="edit">изменить</a>&nbsp; | &nbsp;<a href="?view=del_category&amp;cat_id=<?=$key?>" class="del">удалить</a></td>
</tr>
<?php $i++; ?>
<?php endforeach; ?>      
	</table>
		<a href="?view=add_category"><img class="add_some" src="<?=ADMIN_TEMPLATE?>images/add_kategory.jpg" alt="добавить категорию" /></a>

	</div> <!-- .content -->
	</div> <!-- .content-main -->
</div> <!-- .karkas -->
</body>
</html>