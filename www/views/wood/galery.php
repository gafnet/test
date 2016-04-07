<?php defined('ISHOP') or die('Access denied'); ?>

<div class="kroshka">
	<a href="<?=PATH?>">Главная</a>/ <span><?=$galery['galery_nam']?></span>
</div>

<div class="content-txt">

	<?php if($galery): ?>
        <h1><?=$galery['galery_nam']?></h1>
        <br />
    <?php else: ?>
        <p>Такой галереи нет!</p>
    <?php endif; ?>
	<div class="gallery">
	
    <?php if($files): ?>
		<ul class="images">
        <?php foreach($files as $item):?>
			<li class="image">
				<a href="<?php echo (GALERYS.'/'.$item['file_nam'])?>" rel="lightbox-mygallery" 
					title="<?php echo ($item['file_comment'])?>">
                    <img src="<?php echo (GALERYS.'/thumb/'.$item['file_nam'])?>"
                       alt="<?php echo ($item['file_comment'])?>" />
                  </a>
            </li>
		<?php endforeach; ?>
		</ul>
    <?php else: ?>
        <p>Файлов в галереи нет!</p>
    <?php endif; ?>
	</div> <!-- #gallery -->
</div> <!-- .content-txt -->


