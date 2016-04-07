<?php defined('WOOD') or die('Access denied'); ?>
<div class="content-txt">
<div class="catalog-index">
    <div class="kroshka">
<?php if(count($cat_name) > 1): // если подкатегория (слайдер, моноблок...) ?>
    <a href="<?=PATH?>">Работы мастеров</a> / <a href="<?=PATH?>category/<?=$cat_name[0]['cat_id']?>"><?=$cat_name[0]['cat_name']?></a> / <span><?=$cat_name[1]['cat_name']?></span>
<?php elseif(count($cat_name) == 1): // если не дочерняя категория ?>
    <a href="<?=PATH?>">Работы мастеров</a> / <span><?=$cat_name[0]['cat_name']?></span>
<?php endif; ?>
	</div> <!-- .kroshka -->

<?php if($products): // если получены товары категории ?>
<div class="row div_row">		
<?php foreach($products as $item): ?>

			
	<div class="col-md-3 div_g">
		<a href="?view=product&amp;goods_id=<?=$item['goods_id']?>">
			<img src='<?=$item['pic']?>'  width='140' height='140'>
			<div class="d_name">
				<?=htmlspecialchars($item['name'])?>
			</div>
			<div class="d_avtor"><?=htmlspecialchars($item['site_title'])?></div>
			<div class="d_price"><?=$item['price'].' '.$item['val_abr'] ?></div>
		</a>
		<div class="addcard">
				<a href="<?=PATH?>addtocart/<?=$item['goods_id']?>"><img class="no_box" src="<?=TEMPLATE?>images/addcard.png" 
				alt="Добавить в корзину" 
				title="Добавить в корзину"/></a>
		</div>
	</div>


<?php endforeach; ?>
</div>
<div class="clr"></div>
<?php if($pages_count > 1) pagination($page, $pages_count, $modrew = 0); ?>
<?php else: ?>
    <p>Здесь товаров пока нет!</p>
<?php endif; ?>	
<a name="nav"></a>			
</div> <!-- .catalog-index -->
</div> <!-- .content-txt -->