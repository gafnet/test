<?php defined('WOOD') or die('Access denied'); ?>
<div class="content">
	<h2>Список категорий</h2>
<?php
if(isset($_SESSION['answer'])){
    echo $_SESSION['answer'];
    unset($_SESSION['answer']);
}
?>
	<a href="?view=add_group">Добавить группу</a>
	<table class="tabl" cellspacing="1">
	  <tr>
		<th class="number">№</th>
		<th class="str_name">Название группы</th>
		<th class="str_action">Действие</th>
	  </tr>
<?php $i = 1; ?>
<?php //print_arr($group);?>
<?php foreach($group as $item): ?>
<tr>
	<td><?=$i?></td>
	<td class="name_page"><?=$item['group_nam']?></td>
	<td><a href="?view=edit_group&amp;group_id=<?=$item['group_id']?>" class="edit">изменить</a>&nbsp; | &nbsp;<a href="?view=del_group&amp;group_id=<?=$item['group_id']?>" class="del">удалить</a></td>
</tr>
<?php $i++; ?>
<?php endforeach; ?>      
	</table>
		<a href="?view=add_group"><img class="add_some" src="<?=ADMIN_TEMPLATE?>images/add_kategory.jpg" alt="добавить группу" /></a>

	</div> <!-- .content -->
	</div> <!-- .content-main -->
</div> <!-- .karkas -->
</body>
</html>