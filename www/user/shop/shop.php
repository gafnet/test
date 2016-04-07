<?php defined('WOOD') or die('Access denied'); ?>
<div class="content-txt">
	<?php if($_SESSION['auth']['user']): //Если вошел зарегистрированный пользователь?>
	<h2>Магазин</h2>
	<div id="buttons"><a class="btn btn-primary" href="?view=user/shop/add_product" role="button">Добавить работу</a></div>
    <?php
    
    if(isset($_SESSION['info']['res'])){
        echo $_SESSION['info']['res'];
      }
    
    ?>
<!--		 <script>
  $(function() {
    $( "#tabs" ).tabs();
  });
  </script>
	

	<div class="panel panel-default">
	<div class="panel-heading">Мой магазин</div>
	<div class="panel-body"> -->
		<div id="tabs">
		  <ul class="nav nav-tabs" role="tablist">
			<li <?php if ($visible==1) {?> class="active" <?php } ?> ><a href="<?=PATH?>?view=user/shop/shop" aria-controls="glav" role="tab" data-toggle="tab">Товары магазина (<?=$count_rows_v?>)</a></li>
			<li <?php if ($visible==0) {?> class="active" <?php } ?> ><a href="<?=PATH?>?view=user/shop/shop&cher=0" aria-controls="cher" role="tab" data-toggle="tab">Черновик (<?=$count_rows_c?>)</a></li>
		  </ul>
		  <div role="tabpanel" class="tab-pane <?php if ($visible==1) {?>active<?php } ?>" id="glav">
			<?php if ($visible==1) {
				require('inc_shop.php'); 
			}?>
		  </div>
		  <div role="tabpanel" class="tab-pane <?php if ($visible==0) {?>active<?php } ?>" id="cher">
			<?php if ($visible==0) {
				require('inc_shop.php'); 
			}?>
		  </div>
		</div>
<!--	</div> 	 
	</div> 	-->

	
	<?php else: ?>
		<h3>Для просмотра данной страницы необходимо авторизоваться.</h3>
	<?php endif; ?>
	
	<?php
    
    if(isset($_SESSION['info']['res'])){
        unset($_SESSION['info']);
    }
    
    ?>
</div> <!-- .content-txt -->