<?php defined('WOOD') or die('Access denied'); ?>
<div class="content-txt">
<div style = "min-height:75px;">
	<div id="menu" class="panel panel-default default">
		<div class="panel-body">
			<button type="button" id = "btnSave" class="btn btn-primary">Сохранить</button>
		</div>
	</div>
</div>
<?php
if(isset($_SESSION['info']['res'])){
    echo $_SESSION['info']['res'];
    unset($_SESSION['info']);
}
?>
<div id="goods_id" style="display: none;">0</div>
<form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
	<div class="form-group">
		<label for="site_nam" class="col-sm-3 control-label">*Название работы</label>
		<div class="col-sm-9" >
			<input type="text" name="name" id="name" class="form-control" placeholder="Введите название" value="<?=$_SESSION['add_product']['name']?>"/>
		</div>
	</div>				
	<div class="form-group">
		<label for="site_nam" class="col-sm-3 control-label">Цена</label>
		<div class="col-sm-3" >
			<input type="text" name="price" id="price" class="form-control" 
			placeholder="Введите цену" value="<?=$_SESSION['add_product']['price']?>"/>
		</div>
	</div>				
	<div class="form-group">
		<label for="site_nam" class="col-sm-3 control-label">Ключевые слова</label>
		<div class="col-sm-9" >
			<input type="text" name="keywords" id="keywords" class="form-control" 
			placeholder="Введите ключевые слова" value="<?=$_SESSION['add_product']['keywords']?>"/>
		</div>
	</div>				
	<div class="form-group">
		<label for="site_nam" class="col-sm-3 control-label">Описание</label>
		<div class="col-sm-9" >
			<input type="text" name="description" id="description" class="form-control" 
			placeholder="Введите описание" value="<?=$_SESSION['add_product']['description']?>"/>
		</div>
	</div>				
	<div class="form-group">
		<label for="parent_id" class="col-sm-3 control-label">Раздел</label>
		<div class="col-sm-6" >
			<select class="form-control" name="parent_id" id="parent_id">
				<option value="0">---Выбрать раздел---</option>
				<?php foreach($cat_e as $item): ?>
				<option value="<?=$item['cat_id']?>"><?=$item['cat_name']?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>				
	<div class="form-group">
		<label for="site_nam" class="col-sm-3 control-label">Категория</label>
		<div class="col-sm-6" >
			<select class="form-control" name="goods_catid" id="goods_catid">
			<!--Данные в список загружаются через Ajax-->
			</select>
		</div>
		<div class="load_sp"></div>
	</div>				
	<div class="form-group">
		<label for="site_nam" class="col-sm-3 control-label">Краткое описание</label>
		<div class="col-sm-9" >
			<textarea id="editor1" class="anons-text" name="anons"><?=$_SESSION['add_product']['anons']?></textarea>
		</div>
	</div>				
	<div class="form-group">
		<label for="site_nam" class="col-sm-3 control-label">Подробное описание</label>
		<div class="col-sm-9" >
			<textarea id="editor2" class="anons-text" name="content"><?=$_SESSION['add_product']['content']?></textarea>
		</div>
	</div>	
	<div class="form-group">
		<label for="site_nam" class="col-sm-3 control-label">Отметить как</label>
		<div class="col-sm-9" >
			<input type="checkbox" name="new" value="1" /> Новинка <br />
        	<input type="checkbox" name="hits" value="1" /> Лидер продаж <br />
            <input type="checkbox" name="sale" value="1" /> Распродажа <br />
		</div>
	</div>				
	<div class="form-group">
		<label for="site_nam" class="col-sm-3 control-label">Показывать</label>
		<div class="col-sm-9" >
			<input type="radio" name="visible" value="1" checked="" /> Да <br />
			<input type="radio" name="visible" value="0" /> Нет
		</div>
	</div>				
	<div class="form-group">
		<label for="site_nam" class="col-sm-3 control-label">Изображения</label>
		<div class="col-sm-9" >
			<div class="cont_img">
		
			</div>
			<div id="fileQueue"></div>
				<input type="file" name="uploadify" id="uploadify" />

				<div id="info"></div>
				<div id="info2"></div>
			</div>	
		</div>
	</div>	

</form>
<div class = "load"></div>	
</div>