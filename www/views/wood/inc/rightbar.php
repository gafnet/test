<?php defined('WOOD') or die('Access denied'); ?>
<div id="rightbar">
	<div class="row div_row"> 
		<div class="col-md-12 div_title_r">
			<h2>НОВЫЕ РАБОТЫ</h2>
		</div> 
		<div class="new_work">
			<?php foreach($products_new as $item): ?>
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
	</div>
</div>