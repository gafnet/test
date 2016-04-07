<?php defined('WOOD') or die('Access denied'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="<?=PATH.TEMPLATE?>css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="<?=PATH.TEMPLATE?>css/style.css" />
	<script type="text/javascript" src="<?=PATH.TEMPLATE?>js/jquery.js"></script>
	<script type="text/javascript" src="<?=PATH.TEMPLATE?>js/jquery-ui.js"></script>
	<link rel="stylesheet" type="text/css" href="<?=PATH.TEMPLATE?>js/jquery-ui.css" />
	<script type="text/javascript" src="<?=PATH.TEMPLATE?>js/jquery.cookie.js"></script>

	<script type="text/javascript">
		var path = '<?=PATH?>';
		var userfiles = '<?=USERFILES?>';
	</script>
	<script type="text/javascript" src="<?=PATH.TEMPLATE?>js/workscripts.js"></script>
	<script type="text/javascript" src="<?=PATH;?>lib/ckeditor/ckeditor.js"></script>
	<!--Загрузка библиотеки для обрезки изображений-->
	<link rel="stylesheet" type="text/css" href="<?=PATH;?>lib/JQueryImg/css/imgareaselect-default.css" />
	<!--<script type="text/javascript" src="<?=PATH;?>lib/JQueryImg/scripts/jquery.min.js"></script>-->
	<script type="text/javascript" src="<?=PATH;?>lib/JQueryImg/scripts/jquery.imgareaselect.pack.js"></script>
	<!--Загрузка библиотеки для обрезки изображений-->
	<!--Библиотеки для загрузки изображений-->
	<link href="<?=PATH;?>lib/Uploader/css/default.css" rel="stylesheet" type="text/css" />
	<link href="<?=PATH;?>lib/Uploader/css/uploadify.css" rel="stylesheet" type="text/css" />
	<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>-->
	<script type="text/javascript" src="<?=PATH;?>lib/Uploader/scripts/swfobject.js"></script>
	<script type="text/javascript" src="<?=PATH;?>lib/Uploader/scripts/jquery.uploadify.v2.1.0.min.js"></script>
	<!--Библиотеки для загрузки изображений-->
	<!--Фотогалерея для просмотра изображений
	<link href="<?=PATH?>lib/LightBox2.6/css/screen.css" type="text/css" rel="stylesheet" />-->
	<link href="<?=PATH?>lib/LightBox2.6/css/lightbox.css" type="text/css" rel="stylesheet" />
	<script type="text/javascript" src="<?=PATH?>lib/LightBox2.6/js/lightbox-2.6.min.js"></script>
	<!--Фотогалерея для просмотра изображений-->
	<title>WOOD</title>
</head>

<body>
<div class="main">
	<div class="header">
		<div class="row"> 
		  <div class="col-md-3"><a href="/"><img class="logo" src="<?=PATH.TEMPLATE?>images/maket.png" alt="WoodHand - изделия из дерева ручной работы." /></a></div> 
			<div class="col-md-6">

			</div> 
			<div class="col-md-3">
                <ul class="menu">
					<li><a href="<?=PATH;?>?view=page&page_id=1">О нас</a></li>
					<li><a href="#">Правила</a></li>
					<li><a href="#">Помощь</a></li>
				</ul>
				<div class="auth_form">
					<?php if(!$_SESSION['auth']['user']): ?>
					<form method="post" action="#">
						<input class="btn btn-default" type="button" value="Регистрация / Войти" id="in_site">
					</form>
					<?php else: ?>
						<div id="user_auth">Вы вошли как <strong><?=htmlspecialchars($_SESSION['auth']['user'])?></strong>
						<a href="<?=PATH?>?do=logout">Выход</a></div>
					<?php endif; ?>
				</div>
				<div class="korzina">
                <p>
                <?php if($_SESSION['total_quantity']): ?>
                    <span><?=number_format($_SESSION['total_sum'], 2, '.', ' ')?></span> руб. (<?=$_SESSION['total_quantity']?>)
                    <div class="korzina_l"><a href="<?=PATH?>cart"><img src="<?=PATH.TEMPLATE?>images/basket.png" alt="" /></a></div>
                    <div class="korzina_r"><a href="<?=PATH?>cart"><img src="<?=PATH.TEMPLATE?>images/complect.png" alt="" /></a></div>
					<?php else: ?>
                        Корзина пуста                           
                <?php endif; ?>
                </p>				
				</div>
			</div> 
		</div>
	</div>