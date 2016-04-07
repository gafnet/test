<?php defined('WOOD') or die('Access denied'); ?>

<div class="content-txt">
	<div class="row div_row"> 
		<div class="col-md-6 div_title_p">
			<h2>ПОПУЛЯРНОЕ</h2>
		</div> 
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

</div> <!-- .content-txt -->