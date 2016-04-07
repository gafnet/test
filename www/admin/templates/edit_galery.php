<?php defined('WOOD') or die('Access denied'); ?>

<div class="content">
<h2>Список изображений</h2>
 <?php
if(isset($_SESSION['answer'])){
    echo $_SESSION['answer'];
    unset($_SESSION['answer']);
}
?>
<div>
<a href="?view=add_file&amp;galery_id=<?=$galery_id ?>">Добавить изображение</a>
<table class='tabl' cellspacing='1'>
	<tr class="no_sort">
		<th class="number">Изображение</th>
		<th class="str_name">Описание изображения</th>
		<th class="str_sort">Тип файла</th>
		<th class="str_sort">Размер</th>
		<th class="str_action">Действие</th>
	</tr>
<?php foreach($files as $item): ?>
<tr id='tr_<?php echo $item[file_id]?>' >
	<td>
		<a href="<?php echo (GALERYS.'/'.$item[file_nam])?>" class="highslide" onclick="return hs.expand(this)">
			<img src="<?php echo (GALERYS.'/thumb/'.$item[file_nam])?>" alt="<?php echo ($item[file_comment])?>"
				title="Нажми для увеличения" />
		</a>
	</td>
	<td style="width:360px" class="name_page"><?php echo ($item[file_comment])?></td>
	<td class="position" style="width:80px"><?php echo ($item[type])?></td>
	<td class="position" style="width:80px"><?php echo ($item[size])?></td>
	<td style="width:160px"><a href="?view=edit_file&amp;file_id=<?=$item['file_id']?>" class="edit">изменить</a>&nbsp; | &nbsp;<a href="?view=del_file&amp;file_id=<?=$item['file_id']?>" class="del">удалить</a></td>
</tr>
<?php endforeach; ?> 
</table>
</div>

<a href="?view=add_file&amp;galery_id=<?=$galery_id ?>">Добавить изображение</a>

	</div> <!-- .content -->
<div class="load"></div> <!-- .load -->
<div class="res"></div> <!-- .res -->
	</div> <!-- .content-main -->
</div> <!-- .karkas -->
</body>
</html>
