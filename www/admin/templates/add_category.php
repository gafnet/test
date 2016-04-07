<?php defined('WOOD') or die('Access denied'); ?>
<div class="content">
	
<h2>Добавление категории</h2>
<?php
if(isset($_SESSION['add_category']['res'])){
    echo $_SESSION['add_category']['res'];
    unset($_SESSION['add_category']);
}
?>

<form action="" method="post">
				
	<table class="add_edit_page" cellspacing="0" cellpadding="0">
	  <tr>
		<td class="add-edit-txt">Название категории:</td>
		<td><input class="head-text" type="text" name="cat_name" /></td>
	  </tr>
      <tr>
		<td>Родительская категория:</td>
		<td><select class="select-inf" name="parent_id">
        	<option value="0">Самостоятельная категория</option>
            <?php foreach($cat as $key => $value): ?>
            <option value="<?=$key?>"><?=$value[0]?></option>
            <?php endforeach; ?>
        </select></td>
        </tr>
		<tr>
			<td>Тип категории</td>
			<td>
				<select class="select-inf" name="group_id">
				<?php foreach($category_group as $item): ?>
				<option value="<?=$item['group_id']?>"><?=$item['group_nam']?></option>
				<?php endforeach; ?>
			</select>

			</td>
		</tr>
		<tr>
			<td>Таблица</td> 
			<td>
				<input type="text" enaebled="0"  name="tabl_nam" value="page" />			
			</td>
		</tr>
		<tr>
			<td>Ссылка</td>
			<td>
				
				<select class="select-inf" name="row_id">
				<option value="0">Без ссылки</option>
				<?php foreach($pages as $item): ?>
				<option  value="<?=$item['page_id']?>"><?=$item['title']?></option>
				<?php endforeach; ?>
			</select>
			
			</td>
		</tr>
	</table>
	
	<input type="image" src="<?=ADMIN_TEMPLATE?>images/save_btn.jpg" /> 

</form>

	</div> <!-- .content -->
	</div> <!-- .content-main -->
</div> <!-- .karkas -->
</body>
</html>