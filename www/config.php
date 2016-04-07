<?php

defined('WOOD') or die('Access denied');

// домен
define('PATH', 'http://woodhand1.ru/');

// модель
define('MODEL', 'model/model.php');

// контроллер
define('CONTROLLER', 'controller/controller.php');

// вид
define('VIEW', 'views/');

// папка с активным шаблоном
define('TEMPLATE', VIEW.'wood/');

// папка для файлов пользователя
define('USERFILES', 'userfiles/');

// папка с картинками контента
define('USERFILES_PRODUCTIMG', 'product_img/');

// папка с картинками контента
define('PRODUCTIMG', '/product_img/');

// папка с картинками галереи
define('GALLERYIMG', PATH.'userfiles/product_img/');

// папка с картинками галереи для фотоальбомов
define('GALERYS', PATH.'userfiles/galerys');

// максимально допустимый вес загружаемых картинок - 1 Мб
define('SIZE', 1048576);

// Максимальная ширина для уменьшенной картинки
define('WMAX', '140');

// Максимальная высота для уменьшенной картинки
define('HMAX', '140');

// сервер БД
define('HOST', 'localhost');

// пользователь
define('USER', 'root');

// пароль
define('PASS', '');

// БД
define('DB', 'wood');

// название магазина - title
define('TITLE', 'Работы из дерева');

// email администратора
define('ADMIN_EMAIL', 'gena.falin@gmail.com');

// количество товаров на страницу
define('PERPAGE', 10);

// количество новостей в списке
define('NEWSLIST', 3);

// папка шаблонов административной части
define('ADMIN_TEMPLATE', 'templates/');

//Api key https://console.developers.google.com/apis
define('API_KEY', 'AIzaSyA6k9efSufTKwqIg2rSNsnaAPwtOafJ7so');

/*
 * recaptcha keys:
 * */
define("PUBLICKEY","6LcfnBATAAAAAFQCWhvy07ueF0qHSeAeHb05aP_F");
define("PRIVATEKEY","6LcfnBATAAAAAOcdnyh_K_AO9-vrWbghBKicQQTA");

// Настройки Email
$site['from_name'] = 'Елецгазстрой'; // from (от) имя
$site['from_email'] = 'elgazstr@mail.ru'; // from (от) email адрес

// для дополнительного (внешнего) SMTP сервера.
$site['smtp_mode'] = 'disabled'; // enabled or disabled (включен или выключен)
$site['smtp_host'] = null;
$site['smtp_port'] = null;
$site['smtp_username'] = null;
$site['smtp_password'] = null;

ini_set(‘UPLOAD_MAX_SIZE’, ’64M’); 
ini_set(‘POST_MAX_SIZE’, ’64M’); 
ini_set(‘MAX_EXECUTION_SITE’, ’300’);

mysql_connect(HOST, USER, PASS) or die('No connect to Server');
mysql_select_db(DB) or die('No connect to DB');
mysql_query("SET NAMES 'UTF8'") or die('Cant set charset');