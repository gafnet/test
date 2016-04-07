<?php defined('WOOD') or die('Access denied'); ?>
<div class="content-txt">
    <?php if($get_page): ?>
        <h1><?php if ($get_page['home']<>1) { echo ($get_page['title']);} ?></h1>
        <?=$get_page['text']?>
    <?php else: ?>
        <p>Такой страницы нет!</p>
    <?php endif; ?>
</div> <!-- .content-txt -->