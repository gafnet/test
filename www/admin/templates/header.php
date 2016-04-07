<?php defined('WOOD') or die('Access denied'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?=ADMIN_TEMPLATE?>style.css" />
<script type="text/javascript" src="<?=ADMIN_TEMPLATE;?>js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?=ADMIN_TEMPLATE;?>js/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="<?=ADMIN_TEMPLATE;?>js/jquery.cookie.js"></script>
<script type="text/javascript" src="<?=ADMIN_TEMPLATE;?>js/workscripts.js"></script>
<script type="text/javascript" src="<?=ADMIN_TEMPLATE;?>js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?=ADMIN_TEMPLATE;?>js/ajaxupload.js"></script>

<!--
<script type="text/javascript" src="<?=ADMIN_TEMPLATE;?>../uploads/scripts/upload_files.js"></script>
<script type="text/javascript" src="<?=ADMIN_TEMPLATE;?>../uploads/scripts/swfobject.js"></script>
<script type="text/javascript" src="<?=ADMIN_TEMPLATE;?>../uploads/scripts/jquery.uploadify.v2.1.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?=ADMIN_TEMPLATE?>../uploads/css/default.css" />
<link rel="stylesheet" type="text/css" href="<?=ADMIN_TEMPLATE?>../uploads/css/uploadify.css" />
-->

<title>Список страниц</title>
</head>

<body>
<div class="karkas">
	<div class="head">
		<a href="<?=PATH?>admin/">Панель авминистрирования</a>
		<p><a href="<?=PATH?>" target="_blank">На сайт</a> | <a href="?view=edit_user&amp;user_id=<?=$_SESSION['auth']['user_id']?>"><?=$_SESSION['auth']['admin']?></a> | <a href="?do=logout"><strong>Выйти</strong></a></p>
	</div> <!-- .head -->