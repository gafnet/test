<?php defined('WOOD') or die('Access denied'); ?>
<div class="content-txt">
	<?php if($_SESSION['auth']['user']): //Если вошел зарегистрированный пользователь?>
	<h2>Настройки магазина</h2>
    <?php
    
    if(isset($_SESSION['info']['res'])){
        echo $_SESSION['info']['res'];
      }
    
    ?>
	<div class="panel panel-default">
	<div class="panel-heading">Мой магазин</div>
	<div class="panel-body">
	<?php if ($site) { ?>
    <form method="post" action="" class="form-horizontal">
		<div id="site_id" style="display: none;"><?=$site['site_id']?></div>			
		<div class="form-group">
			<label for="site_nam" class="col-sm-3 control-label">*Название</label>
			<div class="col-sm-9" >
				<input type="text" disabled name="site_nam" id="site_nam" class="form-control" placeholder="Английские символы" value="<?=$site['site_nam']?>"/>
			</div>
		</div>
		<div class="form-group">
			<label for="site_title" class="col-sm-3 control-label">*Заголовок</label>
			<div class="col-sm-9">
				<input type="text" name="site_title" class="form-control" placeholder="Заголовок магазина" value="<?=$site['site_title']?>"/>
			</div>
		</div>
		<div class="form-group">
			<label for="site_rem" class="col-sm-3 control-label">*Описание</label>
			<div class="col-sm-9">
				<input type="text" name="site_rem" class="form-control" placeholder="Введите описание магазина" value="<?=$site['site_rem']?>"/>
			</div>
		</div>
		<div class="form-group">
			<label for="val_id" class="col-sm-3 control-label">*Валюта</label>
			<div class="col-sm-9">
			<select disabled class="form-control" name="val_id" id="val_id">
			<?php foreach($valuta as $item): ?>
				<option <?php if ($item['val_id']==$site['val_id']) {echo "selected ";} ?> value="<?=$item['val_id']?>"><?=$item['val_nam']?></option>
			<?php endforeach; ?>
			</select>
			</div>
		</div>
				

        <input type="submit" name="edit_site" class="btn btn-primary btn-block" value="Сохранить" />
    </form>	
		<?php } else {?>
			Не получены данные о магазине.
		<?php } ?>
	</div> 	 
	</div> 	

	
	<?php else: ?>
		<h3>Для просмотра данной страницы необходимо авторизоваться.</h3>
	<?php endif; ?>
	
	<?php
    
    if(isset($_SESSION['info']['res'])){
        unset($_SESSION['info']);
    }
    
    ?>
</div> <!-- .content-txt -->