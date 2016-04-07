<?php defined('WOOD') or die('Access denied'); ?>
<div id="leftbar">
<?php if($goods): // если есть запрошенный товар ?> 
<div class="panel panel-success">
	<div class="panel-heading">Информация о мастере</div>
	<div class="panel-body">
		<!-- Фото мастера  -->
		<div class="img_master">
			<img src="<?=PATH.$site['site_img']?>"  />
		</div>
		<?php $sites['site_title']?>
		<h4 class="text-center text-success"><?=$site['site_title']?></h4>
		<h6 class="text-center text-warning"><?=$site['site_rem']?></h6>
		<hr/>
		<p>Настроение мастера, объявления и прочая информация.</p>
	</div>
</div>
<div class="panel panel-info">
	<div class="panel-body">
		Профиль
		Магазин (152)
		Отзывы (111) +100%
		Правила магазина
		Персональный заказ
		Блог (39)
		Гостиная
		Круги мастера (834)
		Сообщение мастеру
	</div>
</div>



<?php endif;// конец если есть запрошенный товар ?>



<?php if($_SESSION['auth']['user']): //Если вошел зарегистрированный пользователь
	if(!isset($_SESSION['auth']['site_id'])){
		$no_magazin = True;
	}
?>


 <div class="panel panel-primary">
	 <div class="panel-heading">Мой магазин</div>
	 <div class="panel-body">
	 <!-- Меню управления магазином, покупками  -->
		<ul>
			<li><a href="<?=PATH?>?view=user/shop/settings">Настройки магазина</a></li>
			<li><?php if (!$no_magazin) :?><a href="<?=PATH?>?view=user/shop/shop"><?php endif; ?>Товары магазина</a></li>
			<li><?php if (!$no_magazin) :?><a href="<?=PATH?>?view=user/shop/nastr"><?php endif; ?>Условия доставки</a></li>
		</ul>
	</div>
 </div>
 
 <div class="panel panel-info">
	<div class="panel-heading">Панель управления</div>
	<div class="panel-body">
	<!-- Меню управления магазином, покупками  -->
		<ul>
			<li><a href="<?=PATH?>?view=user/sett/info">Статистика</a></li>
			<li><a href="<?=PATH?>?view=user/sett/prof">Профиль</a></li>
			<li><a href="<?=PATH?>?view=user/sett/nastr">Настройки</a></li>
		</ul>
	</div>
 </div>
<?php endif; ?>


<!--<div class="row div_row"> 
	<div class="col-md-6 div_title_c">
		<h2>Категории</h2>
	</div> 
</div>	-->
<div class="row div_row"> 
		<ul class="nav-catalog" id="accordion">
			<?php foreach($cat as $key => $item): ?>
				<?php if(count($item) > 1): // если это родительская категория ?>
				<h4><li><a href="#"><?=$item[0]?></a></li></h4>
					<ul>
						<li>- <a href="<?=PATH?>?view=cat&category=<?=$key?>">Все работы</a></li>
						<?php foreach($item['sub'] as $key => $sub): ?>
						<li>- <a href="<?=PATH?>?view=cat&category=<?=$key?>"><?=$sub?></a></li>
						<?php endforeach; ?>
					</ul>
				<?php elseif($item[0]): // если самостоятельная категория ?>
					<li><a href="<?=PATH?>?view=cat&category=<?=$key?>"><?=$item[0]?></a></li>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
</div>		 
                <!-- Информеры -->
                <?php foreach($informers as $informer): ?>
                <div class="info">
                    <h3><?=$informer[0]?></h3>
                    <?php foreach($informer['sub'] as $key => $sub): ?>
                    <p>- <a href="<?=PATH?>informer/<?=$key?>"><?=$sub?></a></p>
                    <?php endforeach; ?>
                </div> <!-- .info -->
                <?php endforeach; ?>
                <!-- Информеры -->

</div>