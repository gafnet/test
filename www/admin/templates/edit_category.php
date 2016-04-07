<?php defined('WOOD') or die('Access denied'); ?>
<div class="content">
	
<h2>Редактирование категории</h2>
<?php
if(isset($_SESSION['edit_category']['res'])){
    echo $_SESSION['edit_category']['res'];
    unset($_SESSION['edit_category']);
}
?>

<form action="" method="post">
	<div id="parent_id" style="display: none;"><?=$category['parent_id']?></div>			
	<table class="add_edit_page" cellspacing="0" cellpadding="0">
	  <tr>
		<td class="add-edit-txt">Название категории:</td>
		<td><input class="head-text" type="text" name="cat_name" value="<?=$category['cat_name']?>" /></td>
	  </tr>
	  <tr>
		<td class="add-edit-txt">Позиция страницы:</td>
		<td><input class="num-text" type="text" name="position" value="<?=$category['position']?>" /></td>
	  </tr>
      <tr>
		<td>Родительская категория:</td>
		<?php //print_arr($cat);?>
<?php if(!$cat[$cat_id]['sub']): // если нет подкатегорий ?>
		<td><select class="select-inf" name="parent_id">
        	<option value="0">Самостоятельная категория</option>
            <?php foreach($cat as $key => $value): ?>
            <?php if($value[0] == $cat_name) continue; ?>
            <option <?php if ($key==$category['parent_id']) {echo "selected ";} ?> value="<?=$key?>"><?=$value[0]?></option>
            <?php endforeach; ?>
        </select></td>
<?php else: ?>
    <td>Данная категория содержит подкатегории</td>
<?php endif; ?>
      </tr>
		<tr>
			<td>Тип категории</td>
			<td>
				<select class="select-inf" name="group_id">
				<?php foreach($category_group as $item): ?>
				<option <?php if ($item['group_id']==$category['group_id']) {echo "selected ";} ?> value="<?=$item['group_id']?>"><?=$item['group_nam']?></option>
				<?php endforeach; ?>
			</select>

			</td>
		</tr>
		<tr>
			<td>Таблица</td> 
			<td>
				<select class="select-inf" name="tabl_nam" id="tabl_nam">
				<option value="0">---Выбрать таблицу---</option>
					<option <?php if ($category['tabl_nam']=="page") {echo "selected ";} ?> value="page">Страница</option>
					<option <?php if ($category['tabl_nam']=="galery") {echo "selected ";} ?> value="galery">Фотогалерея</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Ссылка</td>
			<td>
				<select class="select-inf" name="row_id" id="row_id">
				<option value="<?=$category['row_id']?>"></option>
				<!--Данные в список загружаются через Ajax-->
				<!-- <?php foreach($pages as $item): ?>
				<option <?php if ($item['page_id']==$category['row_id']) {echo "selected ";} ?> value="<?=$item['page_id']?>"><?=$item['title']?></option>
				<?php endforeach; ?>
				-->
				</select>
				<div class="load_sp"></div>
			</td>
		</tr>
	</table>
	
	<input type="image" src="<?=ADMIN_TEMPLATE?>images/save_btn.jpg" /> 

</form>
	<div class="res"></div> <!-- .res -->
	</div> <!-- .content -->
	</div> <!-- .content-main -->
</div> <!-- .karkas -->
</body>
</html>