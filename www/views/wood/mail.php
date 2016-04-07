<?php defined('ISHOP') or die('Access denied'); ?>
<div class="content-txt">	
    <h2>Отправка письма</h2>
    <?php
    
    if(isset($_SESSION['mess']['res'])){
        echo $_SESSION['mess']['res'];
    }
    
    ?>    <form method="post" action="">
        <table class="zakaz-data" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td class="zakaz-txt">*Ваше имя</td>
                <td class="zakaz-inpt"><input type="text" name="name" value="<?=htmlspecialchars($_SESSION['mess']['name'])?>" /></td>
                <td class="zakaz-prim">Пример: Сергей Александрович</td>
            </tr>
            <tr>
                <td class="zakaz-txt">*Е-маил</td>
                <td class="zakaz-inpt"><input type="text" name="email" value="<?=htmlspecialchars($_SESSION['mess']['email'])?>" /></td>
                <td class="zakaz-prim">Пример: test@mail.ru</td>
            </tr>
            <tr>
                <td class="zakaz-txt">*Сообщение</td>
                <td class="zakaz-inpt"><textarea rows="6" cols="40" name="message" ><?=htmlspecialchars($_SESSION['mess']['message'])?></textarea></td>
                <td class="zakaz-prim"></td>
            </tr>
            <tr>
                <td class="zakaz-txt"></td>
                <td class="zakaz-inpt">
				<div class="g-recaptcha" data-sitekey="<?php echo(PUBLICKEY)?>"></div>
				</td>
                <td class="zakaz-prim"></td>
            </tr>
 		</table>
        <input type="submit" name="mail" value="Отправить письмо" />
    </form>	
    
    <?php
    
    if(isset($_SESSION['mess']['res'])){
        unset($_SESSION['mess']);
    }
    
    ?>

</div> <!-- .content-txt -->

