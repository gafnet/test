<?php defined('ISHOP') or die('Access denied'); ?>
<div class="catalog-index">
    <h1>Результаты поиска</h1>
    <?php if($result_search['notfound']): // если ничего не найдено ?>
        <?php echo $result_search['notfound'] ?>
    <?php else: // если есть результаты поиска ?>
<?php for($i = $start_pos; $i < $endpos; $i++): ?>
<!-- Табличный вид продуктов -->				
<div class="product-table">
	<h2><a href="<?=PATH?>product/<?=$result_search[$i]['goods_id']?>"><?=$result_search[$i]['name']?></a></h2>
<div class="product-table-img-main">
    <div class="product-table-img">
		<a href="<?=PATH?>product/<?=$result_search[$i]['goods_id']?>"><img src="<?=PRODUCTIMG?><?=$result_search[$i]['img']?>" alt="" width="64" /></a>
		<div> <!-- Иконки -->
            <?php if($result_search[$i]['hits']) echo '<img src="' .TEMPLATE. 'images/ico-cat-lider.png" alt="лидеры продаж" />'; ?>
            <?php if($result_search[$i]['new']) echo '<img src="' .TEMPLATE. 'images/ico-cat-new.png" alt="новинка" />'; ?>
            <?php if($result_search[$i]['sale']) echo '<img src="' .TEMPLATE. 'images/ico-cat-sale.png" alt="распродажа" />'; ?>							
		</div> <!-- Иконки -->
	</div> <!-- .product-table-img -->
</div> <!-- .product-table-img-main -->
	<p class="cat-table-more"><a href="<?=PATH?>product/<?=$result_search[$i]['goods_id']?>">подробнее...</a></p>
	<p>Цена :  <span><?=$result_search[$i]['price']?></span></p>
	<a href="<?=PATH?>addtocart/<?=$result_search[$i]['goods_id']?>"><img class="addtocard-index" src="<?=TEMPLATE?>images/addcard-table.jpg" alt="Добавить в корзину" /></a>
</div> <!-- .product-table -->
<!-- Табличный вид продуктов -->
<?php endfor; ?>
<div class="clr"></div>
<?php if($pages_count > 1) pagination($page, $pages_count, $modrew = 0); ?>
    <?php endif; ?>
</div> <!-- .catalog-index -->