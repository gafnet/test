<?php require_once 'inc/header.php' ?>
	<div id="contentwrapper" class="row">
	<div class="col-md-3"><?php require_once 'inc/leftbar.php' ?></div><!-- #leftbar -->
	<?php if ($show_right_panel) {?>
		<div class="col-md-6"><div id="content"><?php include $view. '.php' ?></div></div><!-- #content -->
		<div class="col-md-3"><?php require_once 'inc/rightbar.php' ?></div>  <!-- #rightbar -->
	<?php } else { ?>
		<div class="col-md-9"><div id="content"><?php include $view. '.php' ?></div></div><!-- #content -->
	<?php } ?>
	</div><!-- #contentwrapper -->

	<div class="clr"></div>	
<?php require_once 'inc/footer.php' ?>