<?php defined('WOOD') or die('Access denied'); ?>
<div class="content-txt">
    <?php if($text_informer): ?>
        <h1><?=$text_informer['link_name']?></h1>
        <?=$text_informer['text']?>
    <?php else: ?>
        <p>Такой страницы нет!</p>
    <?php endif; ?>
</div> <!-- .content-txt -->