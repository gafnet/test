<?php defined('WOOD') or die('Access denied'); ?>

<div class="content">

<div>
    
 <h3>Загрузка файлов на сервер:</h3>
 <?php
if(isset($_SESSION['error']['res'])){
    echo $_SESSION['error']['res'];
	unset($_SESSION['error']);  
}
?>
<div id="galery_id" style="display: none;"><?=$galery_id?></div>
 <form action="" method="post" enctype="multipart/form-data">
	<table class="add_edit_page" cellspacing="0" cellpadding="0">
	  <tr>
		<td class="add-edit-txt">Описание картинки:</td>
		<td><input class="head-text" type="text" name="file_comment" /></td>
	  </tr>
	  <tr>
		<td class="add-edit-txt">Картинка:</td>
		<td><input type="file" name="name_file" /></td>
	  </tr>
	</table>



    <div id="info"></div>
    <div id="info2"></div>
	<input type="image" src="<?=ADMIN_TEMPLATE?>images/save_btn.jpg" /> 
</form>
</div>
</div> <!-- .content -->
<div class="load"></div> <!-- .load -->
<div class="res"></div> <!-- .res -->
	</div> <!-- .content-main -->
</div> <!-- .karkas -->
</body>
</html>
