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

<div id="goods_id" style="display: none;"><?=$get_product['goods_id']?></div>
<form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
	<div class="form-group">
		<label for="site_nam" class="col-sm-3 control-label">*Название работы</label>
		<div class="col-sm-9" >
			<input type="text" name="name" id="name" class="form-control"
			value="<?=htmlspecialchars($get_product['name'])?>"/>
		</div>
	</div>				
	<div class="form-group">
		<label for="site_nam" class="col-sm-3 control-label">Цена</label>
		<div class="col-sm-3" >
			<input type="text" name="price" id="price" class="form-control" 
			 value="<?=$get_product['price']?>"/>
		</div>
	</div>				
	<div class="form-group">
		<label for="site_nam" class="col-sm-3 control-label">Ключевые слова</label>
		<div class="col-sm-9" >
			<input type="text" name="keywords" id="keywords" class="form-control" 
			 value="<?=htmlspecialchars($get_product['keywords'])?>"/>
		</div>
	</div>				
	<div class="form-group">
		<label for="site_nam" class="col-sm-3 control-label">Описание</label>
		<div class="col-sm-9" >
			<input type="text" name="description" id="description" class="form-control" 
			 value="<?=htmlspecialchars($get_product['description'])?>"/>
		</div>
	</div>				
	<div class="form-group">
		<label for="parent_id" class="col-sm-3 control-label">Раздел</label>
		<div class="col-sm-6" >
			<select class="form-control" name="parent_id" id="parent_id">
				<?php foreach($cat_e as $item): ?>
				<option <?php if ($item['cat_id']==$get_product['parent_id']) {echo "selected ";} ?> value="<?=$item['cat_id']?>"><?=$item['cat_name']?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>				
	<div class="form-group">
		<label for="site_nam" class="col-sm-3 control-label">Категория</label>
		<div class="col-sm-6" >
			<select class="form-control" name="goods_catid" id="goods_catid">
			<option value="<?=$get_product['goods_catid']?>"></option>
			<!--Данные в список загружаются через Ajax-->
			</select>
		</div>
		<div class="load_sp"></div>
	</div>				
	<div class="form-group">
		<label for="site_nam" class="col-sm-3 control-label">Краткое описание</label>
		<div class="col-sm-9" >
			<textarea id="editor1" name="anons"><?=htmlspecialchars($get_product['anons'])?></textarea>
			<script type="text/javascript">
				//CKEDITOR.replace( 'editor1' );
			</script>
		</div>
	</div>				
	<div class="form-group">
		<label for="site_nam" class="col-sm-3 control-label">Подробное описание</label>
		<div class="col-sm-9" >
			<textarea id="editor2" name="content"><?=htmlspecialchars($get_product['content'])?></textarea>
			<script type="text/javascript">
				//CKEDITOR.replace( 'editor2' );
			</script>
		</div>
	</div>	
	<div class="form-group">
		<label for="site_nam" class="col-sm-3 control-label">Отметить как</label>
		<div class="col-sm-9" >
			<input type="checkbox" name="new" id="new" <?php if($get_product['new']) echo 'checked=""'; ?> /> Новинка <br />
        	<input type="checkbox" name="hits" id="hits" <?php if($get_product['hits']) echo 'checked=""'; ?> /> Лидер продаж <br />
            <input type="checkbox" name="sale" id="sale" <?php if($get_product['sale']) echo 'checked=""'; ?> /> Распродажа <br />
		</div>
	</div>				
	<div class="form-group">
		<label for="site_nam" class="col-sm-3 control-label">Показывать</label>
		<div class="col-sm-9" >
			<input type="radio" name="visible" value="1" <?php if($get_product['visible']) echo 'checked=""'; ?> /> Да <br />
			<input type="radio" name="visible" value="0" <?php if(!$get_product['visible']) echo 'checked=""'; ?> /> Нет
		</div>
	</div>				
	<div class="form-group">
		<label for="site_nam" class="col-sm-3 control-label">Изображения</label>
		<div class="col-sm-9" >
			<div class="cont_img">
				<?php foreach($goods_pic as $img): ?>
				<div class = "pic_content">
					<div class = "pic_img">
						<img id='pic_<?=$img['pic_id']?>' src='<?=$img['pic_path']."m_".$img['pic_name']?>'>
					</div>
					<div class = "pic_dop">
						<textarea name ='name' id ='name_<?=$img['pic_id']?>'><?=htmlspecialchars($img['name']) ?></textarea>
						<input type='checkbox' name="glav" value="1" id ='glav_<?=$img['pic_id']?>' <?php if($img['glav']) echo 'checked=""'; ?> /> Главное изображение <br />
						<input type='checkbox' name="del" id ='del_<?=$img['pic_id']?>'/> Отметить к удалению<br />
						<input type="hidden" name="x1" value="<?=$img['x1']?>" id="x1_<?=$img['pic_id']?>" />
						<input type="hidden" name="y1" value="<?=$img['y1']?>" id="y1_<?=$img['pic_id']?>" />
						<input type="hidden" name="x2" value="<?=$img['x2']?>" id="x2_<?=$img['pic_id']?>" />
						<input type="hidden" name="y2" value="<?=$img['y2']?>" id="y2_<?=$img['pic_id']?>" />
					</div>
				</div>
			<?php endforeach; ?>				
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

