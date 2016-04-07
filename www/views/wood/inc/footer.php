<?php defined('WOOD') or die('Access denied'); ?>
<div class="footer">
	<div  class="row">
	 <div  class="col-sm-4 col-lg-3"></div>
	 <div  class="col-sm-4 col-lg-6">
		<h3 class="text-center">Получайте новости магазина WoodHand</h3><br/>
		<form class="form-horizontal">
			<div class="form-group">
			  <label for="mail" class="col-sm-2 control-label">Email</label>
			  <div class="col-sm-8">
			   <input type="email" class="form-control" id="mail" placeholder="Email">
			  </div>
			</div>
			<div class="form-group">
				<div class="col-sm-12">
					<button type="submit" class="btn btn-info btn-block">Подписаться</button>
				</div>
			</div>
		</form>
	 </div>
	 <div  class="col-sm-4 col-lg-3"></div>
	</div>
</div>	<!-- .footer -->
	<div id="enter" class="enter" title="Авторизация">
		<div class="authform">
			<?php if(!$_SESSION['auth']['user']): ?>
			<form method="post" action="#" role="form">
				<div class="form-group">
				<label for="login_auth">Логин: </label>
				<input type="text" name="login_auth" id="login_auth" class="form-control" placeholder="Введите login"/>
				</div>
				<div class="form-group">
				<label for="pass">Пароль: </label><br />
				<input type="password" name="pass" id="pass" class="form-control" placeholder="Пароль" />
				</div>
				<input type="submit" name="auth" id="auth" class="btn btn-success btn-block" value="Войти" />
				<p class="link"><a href="<?=PATH?>reg">Регистрация</a></p>
			</form>
			<?php
				if(isset($_SESSION['auth']['error'])){
					echo '<div class="error">' .$_SESSION['auth']['error']. '</div>';
					unset($_SESSION['auth']);
				}
			?>
			<?php else: ?>
				<p>Добро пожаловать, <?=htmlspecialchars($_SESSION['auth']['user'])?></p>
				<a href="<?=PATH?>?do=logout">Выход</a>
			<?php endif; ?>
		</div> <!-- .authform -->	
	</div> <!-- .enter -->	
	
</div>




</body>
</html>