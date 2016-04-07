<?php defined('WOOD') or die('Access denied'); ?>
	<div class="content-main">
<?php if($count_new_orders > 0): ?>
<p class="new_orders"><a href="?view=orders&amp;status=0">Есть новые заказы (<?=$count_new_orders?>)</a></p>
<?php endif; ?>
		<div class="leftBar">
			<ul class="nav-left">
				<li><a <?=active_url()?> href="<?=PATH?>admin/">Основные страницы</a></li>
				<li><a <?=active_url("view=informers")?> href="?view=informers">Информеры</a></li>
				<li><a <?=active_url("view=groups")?> href="?view=groups">Группы для категорий</a></li>
				<li><a <?=active_url("view=categorys")?> href="?view=categorys">Основные категории</a></li>

<!-- Аккордеон 
<ul class="nav-catalog" id="accordion">
    <?php foreach($cat as $key => $item): ?>
        <?php if(count($item) > 1): // если это родительская категория ?>
        <h3><li><a style="font-size: 13px;" href="#"><?=$item[0]?></a></li></h3>
            <ul>
                <li>- <a <?=active_url("category=$key")?> href="?view=cat&amp;category=<?=$key?>">Все модели</a></li>
                <?php foreach($item['sub'] as $key => $sub): ?>
                <li>- <a <?=active_url("category=$key")?> href="?view=cat&amp;category=<?=$key?>"><?=$sub?></a></li>
                <?php endforeach; ?>
            </ul>
        <?php elseif($item[0]): // если самостоятельная категория ?>
            <li><a <?=active_url("category=$key")?> href="?view=cat&amp;category=<?=$key?>"><?=$item[0]?></a></li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>
Аккордеон -->

				<li><a <?=active_url("view=news")?> href="?view=news">Новости</a></li>
                <!--<li><a <?=active_url("view=orders")?> href="?view=orders">Заказы</a></li>-->
				<li><a <?=active_url("view=galerys")?> href="?view=galerys">Галереи</a></li>
				<li><a <?=active_url("view=users")?> href="?view=users">Пользователи</a></li>
			</ul>
		</div> <!-- .leftBar -->