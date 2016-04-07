<?php defined('WOOD') or die('Access denied'); ?>

<?php if($goods): // если есть запрошенный товар ?>  
<!-- <div class="kroshka">
<?php if(count($cat_name) > 1): // если подкатегория (слайдер, моноблок...) ?>
    <a href="<?=PATH?>">Мобильные телефоны</a> / <a href="<?=PATH?>category/<?=$cat_name[0]['cat_id']?>"><?=$cat_name[0]['cat_name']?></a> / <a href="<?=PATH?>category/<?=$cat_name[1]['cat_id']?>"><?=$cat_name[1]['cat_name']?></a> / <span><?=$goods['name']?></span>
<?php elseif(count($cat_name) == 1): // если не дочерняя категория ?>
    <a href="<?=PATH?>">Мобильные телефоны</a> / <a href="<?=PATH?>category/<?=$cat_name[0]['cat_id']?>"><?=$cat_name[0]['cat_name']?></a> / <span><?=$goods['name']?></span>
<?php endif; ?>
</div>  .kroshka -->

<div class="catalog-detail">
<h3 class="text-primary"><?=$goods['name']?></h3>

<div class="picture" >
	<a data-lightbox="example-set" title="<?=$goods['name']?>" href="<?=PATH.str_replace('/m_','/',$goods['pic'])?>" />
	<img src="<?=PATH.$goods['pic']?>"  />
	</a>
</div>

<div class="short-opais">
    <?=$goods['anons']?>
    <h4 class="text-danger">Цена :  <span><?=$goods['price']?></span></h4>
    <a href="<?=PATH?>addtocart/<?=$goods['goods_id']?>"><img class="addtocard-index" src="<?=PATH.TEMPLATE?>images/addcard-detail.jpg" alt="Добавить в корзину" /></a>
</div> <!-- .short-opais -->

<div class="clr"></div>

<?php //if($goods['img_slide']): // если есть картинки галереи ?>
<div class="item_gallery">
   <div class="item_thumbs">
   <?php foreach($goods_pic as $img): ?>
       <a data-lightbox="example-set" title="<?= $img['name'] ? $img['name'] : $goods['name'] ?>" href="<?=PATH.$img['pic_path'].$img['pic_name']?>" />
		<img id='pic_<?=$img['pic_id']?>' src='<?=PATH.$img['pic_path']."t_".$img['pic_name']?>' width=90 height=90>
	   </a>
   <?php endforeach; ?>
   </div> <!-- .item_thumbs -->
</div> <!-- .item_gallery -->
<?php //endif; ?>

<div class="long-opais">
<?=$goods['content']?>				
</div> <!-- .long-opais -->
   
</div> <!-- .catalog-detail -->

<?php else: ?>
    <div class="error">Такого товара нет</div>
<?php endif; ?>