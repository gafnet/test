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
	Показать категории для 
	<select class="select-inf" name="group_id" id="group_id">
		<?php foreach($category_group as $item): ?>
		<option <?php if ($item['group_id']==$group_id) {echo "selected ";} ?> value="<?=$item['group_id']?>"><?=$item['group_nam']?></option>
	<?php endforeach; ?>
	</select>

	<table class="tabl" cellspacing="1">
	  <tr>
		<th class="number">№</th>
		<th class="str_name">Название страницы</th>
		<th class="str_sort">Сортировка</th>
		<th class="str_action">Действие</th>
	  </tr>
<?php $i = 1; ?>

<tr>
	<?php if ($parent_id==0) { ?>
		<td style="text-align:left;" colspan="4">Родительский уровень</td>
	<?php } else { ?>
		<td style="text-align:left;" colspan="4"><a href="?view=categorys&amp;p_id=<?=$pparent?>">Переход на уровень вверх</a></td>
	<?php } ?>
</tr>
<?php //echo($pparent); //print_arr($categorys);?>
<?php foreach($categorys as $item):?>
<tr>
	<td><?=$i?></td>
	<td style="width:360px" class="name_page"><a href="?view=categorys&amp;p_id=<?=$item['cat_id']?>"><?=$item['cat_name']?></a></td>
	<td class="position" style="width:80px"><?=$item['position']?></td>
	<td><a href="?view=edit_category&amp;cat_id=<?=$item['cat_id']?>" class="edit">изменить</a>&nbsp; | &nbsp;<a href="?view=del_category&amp;cat_id=<?=$item['cat_id']?>" class="del">удалить</a></td>
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