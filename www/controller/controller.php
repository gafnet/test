<?php

/* $file_name='log.txt'; // 1
$w=fopen($file_name,'w'); // 6
fwrite($w,"\r\n cropped ");  // 7
fclose($w);  // 8 
*/


defined('WOOD') or die('Access denied');

session_start();

// подключение модели
require_once MODEL;

// подключение библиотеки функций
require_once 'functions/functions.php';

//Подключаем recaptcha library
require_once "functions/recaptchalib.php";

// получение массива каталога
$cat = catalog(2); 

// получение массива информеров
$informers = informer();

// получени массива страниц
//$pages = pages();

// получение названия новостей
//$news = get_title_news(1);

// получение названия новостей
//$vacans = get_title_news(2);

// регистрация
if($_POST['reg']){
    registration();
    redirect();
}


// авторизация
if($_POST['auth']){
	authorization();
    if($_SESSION['auth']['user']){
		redirect();
        // если пользователь авторизовался
        //echo "<p>Добро пожаловать, {$_SESSION['auth']['user']}</p>";
        //exit;
    }else{
        // если авторизация неудачна
        echo $_SESSION['auth']['error'];
        unset($_SESSION['auth']);
        exit;
    }
}

// выход пользователя
if($_GET['do'] == 'logout'){
    logout();
    redirect();
}

// массив метаданных
$meta = array();

// Получение данных через ajax
if($_POST['ajax']){
 //Получение данных для формы добавления и редактирования товара
 if($_POST['parent_id']){
	$parent_id = (int)$_POST['parent_id'];
	get_catalog_by_parent(2,$parent_id);
 }
  //Сохранение данных картинок товара edit_product
 if($_POST['pic_id']){
	$pic_id = (int)$_POST['pic_id'];
	if ($pic_id > 0) {
		if ($_POST['del']) {
			goods_pic_del($pic_id);
		}else{
			goods_pic_edit($pic_id);
		}
	} else {
		goods_pic_add($goods_id);
	}
 }
   //Сохранение данных товара edit_product
   if($_POST['edit_product']){
	$goods_id = (int)$_POST['goods_id'];
	if ($goods_id>0) {
		edit_product($goods_id);
	}else{
	add_product();
	}
 }

   //Удаление данных товара del_product
   if($_POST['del_product']){
	$goods_id = (int)$_POST['goods_id'];
	if ($goods_id>0) {
		del_product($goods_id);
	}
} 
 return;
}

// получение динамичной части шаблона #content
$view = empty($_GET['view']) ? 'hits' : $_GET['view'];
$show_right_panel=True;
switch($view){
    case('home'):
        // лидеры продаж
        $get_page = get_page_home();
        $meta['title'] = "{$get_page['title']} | " .TITLE;
        $meta['description'] = "{$get_page['description']} | " .TITLE;
		$view = 'page';
    break;
    case('hits'):
        /* =====Сортировка===== */
        // массив параметров сортировки
        // ключи - то, что передаем GET-параметром
        // значения - то, что показываем пользователю и часть SQL-запроса, который передаем в модель
        $order_p = array(
                        'pricea' => array('от дешевых к дорогим', 'price ASC'),
                        'priced' => array('от дорогих к дешевым', 'price DESC'),
                        'datea' => array('по дате добавления - к последним', 'date ASC'),
                        'dated' => array('по дате добавления - с последних', 'date DESC'),
                        'namea' => array('от А до Я', 'name ASC'),
                        'named' => array('от Я до А', 'name DESC')
                        );
        $order_get = clear($_GET['order']); // получаем возможный параметр сортировки
        if(array_key_exists($order_get, $order_p)){
            $order = $order_p[$order_get][0];
            $order_db = $order_p[$order_get][1];
        }else{
            // по умолчанию сортировка по первому элементу массива order_p
            $order = $order_p['namea'][0];
            $order_db = $order_p['namea'][1];
        }
        /* =====Сортировка===== */
        // параметры для навигации
        $perpage = 10; // кол-во товаров на страницу
        if(isset($_GET['page'])){
            $page = (int)$_GET['page'];
            if($page < 1) $page = 1;
        }else{
            $page = 1;
        }
        $count_rows = count_rows('none'); // общее кол-во товаров
        $pages_count = ceil($count_rows / $perpage); // кол-во страниц
        if(!$pages_count) $pages_count = 1; // минимум 1 страница
        if($page > $pages_count) $page = $pages_count; // если запрошенная страница больше максимума
        $start_pos = ($page - 1) * $perpage; // начальная позиция для запроса
        $products = products_by_site(0 , $order_db, $start_pos, $perpage); // получаем массив из модели
    break;
    
    case('new'):
        // новинки
        $eyestoppers = eyestopper('new');
        $meta['title'] = "Новинки | " .TITLE;
        $meta['description'] = "Новинки | " .TITLE;
    break;
    
    case('sale'):
        // распродажа
        $eyestoppers = eyestopper('sale');
        $meta['title'] = "Распродажа | " .TITLE;
        $meta['description'] = "Новинки | " .TITLE;
    break;
    
    case('page'):
        // отдельная страница
        $page_id = abs((int)$_GET['page_id']);
        $get_page = get_page($page_id);
        $meta['title'] = "{$get_page['title']} | " .TITLE;
        $meta['description'] = "{$get_page['description']} | " .TITLE;
    break;
    
    case('news'):
        // отдельная новость
        $news_id = abs((int)$_GET['news_id']);
        $news_text = get_news_text($news_id);
    break;
    
    case('archive'):
        // все новости (архив новостей)
        // параметры для навигации
        $perpage = 10; // кол-во товаров на страницу
        if(isset($_GET['page'])){
            $page = (int)$_GET['page'];
            if($page < 1) $page = 1;
        }else{
            $page = 1;
        }
        $count_rows = count_news(); // общее кол-во новостей
        $pages_count = ceil($count_rows / $perpage); // кол-во страниц
        if(!$pages_count) $pages_count = 1; // минимум 1 страница
        if($page > $pages_count) $page = $pages_count; // если запрошенная страница больше максимума
        $start_pos = ($page - 1) * $perpage; // начальная позиция для запроса
        
        $all_news = get_all_news($start_pos, $perpage,1);
    break;
    
    case('informer'):
        // текст информера
        $informer_id = abs((int)$_GET['informer_id']);
        $text_informer = get_text_informer($informer_id);
    break;
    
    case('cat'):
        // товары категории
        $category = abs((int)$_GET['category']);
        
        /* =====Сортировка===== */
        // массив параметров сортировки
        // ключи - то, что передаем GET-параметром
        // значения - то, что показываем пользователю и часть SQL-запроса, который передаем в модель
        $order_p = array(
                        'pricea' => array('от дешевых к дорогим', 'price ASC'),
                        'priced' => array('от дорогих к дешевым', 'price DESC'),
                        'datea' => array('по дате добавления - к последним', 'date ASC'),
                        'dated' => array('по дате добавления - с последних', 'date DESC'),
                        'namea' => array('от А до Я', 'name ASC'),
                        'named' => array('от Я до А', 'name DESC')
                        );
        $order_get = clear($_GET['order']); // получаем возможный параметр сортировки
        if(array_key_exists($order_get, $order_p)){
            $order = $order_p[$order_get][0];
            $order_db = $order_p[$order_get][1];
        }else{
            // по умолчанию сортировка по первому элементу массива order_p
            $order = $order_p['namea'][0];
            $order_db = $order_p['namea'][1];
        }
        /* =====Сортировка===== */
        
        // параметры для навигации
        $perpage = PERPAGE; // кол-во товаров на страницу
        if(isset($_GET['page'])){
            $page = (int)$_GET['page'];
            if($page < 1) $page = 1;
        }else{
            $page = 1;
        }
        $count_rows = count_rows("goods_catid", $category); // общее кол-во товаров
        $count_rows = $count_rows + count_rows("parent_id", $category); // общее кол-во товаров
        $pages_count = ceil($count_rows / $perpage); // кол-во страниц
        if(!$pages_count) $pages_count = 1; // минимум 1 страница
        if($page > $pages_count) $page = $pages_count; // если запрошенная страница больше максимума
        $start_pos = ($page - 1) * $perpage; // начальная позиция для запроса
        
        $cat_name = cat_name($category); // хлебные крохи
        $products = products($category, $order_db, $start_pos, $perpage); // получаем массив из модели
        $meta['title'] = $cat_name[0]['cat_name'];
        if($cat_name[1]) $meta['title'] .= " - {$cat_name[1]['cat_name']}";
        $meta['title'] .= " | " .TITLE;
        $meta['description'] = "{$cat_name[0]['cat_name']}, {$cat_name[1]['cat_name']}";
    break;
    
    case('addtocart'):
        // добавление в корзину
        $goods_id = abs((int)$_GET['goods_id']);
        addtocart($goods_id);
        
        $_SESSION['total_sum'] = total_sum($_SESSION['cart']);
        
        // кол-во товара в корзине + защита от ввода несуществующего ID товара
        total_quantity();
        redirect();
    break;
    
    case('cart'):
        /* корзина */
        // получение способов доставки
		$show_right_panel=False;
        $dostavka = get_dostavka();
        
        // пересчет товаров в корзине
        if(isset($_GET['id'], $_GET['qty'])){
            $goods_id = abs((int)$_GET['id']);
            $qty = abs((int)$_GET['qty']);
            
            $qty = $qty - $_SESSION['cart'][$goods_id]['qty'];
            addtocart($goods_id, $qty);
            
            $_SESSION['total_sum'] = total_sum($_SESSION['cart']); // сумма заказа
            
            total_quantity(); // кол-во товара в корзине + защита от ввода несуществующего ID товара
            redirect();
        }
        // удаление товара из корзины
        if(isset($_GET['delete'])){
            $id = abs((int)$_GET['delete']);
            if($id){
                delete_from_cart($id);
            }
            redirect();
        }
        
        if($_POST['order_x']){
            add_order();
            redirect();
        }
    break;
    
    case('reg'):
        // регистрация
    break;

    case('mail'):
        // письмо
		// отправка письма
		if($_POST['mail']){

			send_mail();
			redirect();
		}    
	break;
    
    case('search'):
        // поиск
        $result_search = search();
        
        // параметры для навигации
        $perpage = 9; // кол-во товаров на страницу
        if(isset($_GET['page'])){
            $page = (int)$_GET['page'];
            if($page < 1) $page = 1;
        }else{
            $page = 1;
        }
        $count_rows = count($result_search); // общее кол-во товаров
        $pages_count = ceil($count_rows / $perpage); // кол-во страниц
        if(!$pages_count) $pages_count = 1; // минимум 1 страница
        if($page > $pages_count) $page = $pages_count; // если запрошенная страница больше максимума
        $start_pos = ($page - 1) * $perpage; // начальная позиция для запроса
        $endpos = $start_pos + $perpage; // до какого товара будет вывод на странице
        if($endpos > $count_rows) $endpos = $count_rows;
    break;
    
    case('filter'):
        // выбор по параметрам
        $startprice = (int)$_GET['startprice'];
        $endprice = (int)$_GET['endprice'];
        $category = array();
        
        if($_GET['category']){
            foreach($_GET['category'] as $value){
                $value = (int)$value;
                $category[$value] = $value;
            }
        }
        if($category){
            $category = implode(',', $category);
        }
        $products = filter($category, $startprice, $endprice);
    break;
    
    case('product'):
        // отдельный товар
        $goods_id = abs( (int)$_GET['goods_id'] );
        if($goods_id){
            $goods = get_product($goods_id);
            if($goods) $cat_name = cat_name($goods['goods_catid']); // хлебные крошки
			//Получаем изображения к товару
			$goods_pic = get_goods_pic($goods_id);
			//Получаем информацию по сайту
			$site = get_site($goods['site_id']);
			if (!$site['site_img']){
				$site['site_img'] = TEMPLATE.'images/human.png';
			}
        }
    break;

    case('galery'):
        // Галерея
		$galery_id = (int)$_GET['galery_id'];
        $galery = get_galery($galery_id);
        $files = get_galery_files($galery_id);
    break;

    case('user/sett/info'):
		// Получаем информацию по сайтам, по владельцу иагазина
		if ($_SESSION['auth']['customer_id']) {
			// Обработка нажатия создания магазина, сайта
			if($_POST['add_site']){
				add_site();
				redirect();
			}        
			$sites = get_sites($_SESSION['auth']['customer_id']);
		}
		// Получаем информацию по валютам
		$valuta = get_valuta();
    break;

    case('user/sett/prof'):
		// Получаем информацию по сайтам, по владельцу иагазина
		
		if ($_SESSION['auth']['customer_id']) {
			
			$user = get_user($_SESSION['auth']['customer_id']);

			if($_POST['btn_save']){
				prof_save($_SESSION['auth']['customer_id'], $user['path_files']);
				redirect();
			}         

		}
		// Получаем информацию по валютам
		$valuta = get_valuta();
    break;

    case('user/shop/settings'):
		// Получаем информацию по сайтам, по владельцу иагазина
		if ($_SESSION['auth']['customer_id']) {
			// Обработка нажатия создания магазина, сайта
			if($_POST['add_site']){
				add_site();
				redirect();
			} 
			$sites = get_sites($_SESSION['auth']['customer_id']);
			$valuta = get_valuta();
		}
    break;

    case('user/shop/setting_edit'):
		// Редактирование настроек магазина
		if ($_SESSION['auth']['customer_id']) {
			// Обработка нажатия создания магазина, сайта
			if($_GET['site_id']){
				$site_id = $_SESSION['auth']['site_id'];
				$site = get_site($site_id);
				$valuta = get_valuta();
				if($_POST['edit_site']){
					edit_site($site_id);
					redirect();
				} 
			}
		}
    break;

    case('user/shop/shop'):
		if(!isset($_SESSION['auth']['site_id'])){
			redirect(PATH);
		}
        /* =====Сортировка===== */
        // массив параметров сортировки
        // ключи - то, что передаем GET-параметром
        // значения - то, что показываем пользователю и часть SQL-запроса, который передаем в модель
        $order_p = array(
                        'pricea' => array('от дешевых к дорогим', 'price ASC'),
                        'priced' => array('от дорогих к дешевым', 'price DESC'),
                        'datea' => array('по дате добавления - к последним', 'date ASC'),
                        'dated' => array('по дате добавления - с последних', 'date DESC'),
                        'namea' => array('от А до Я', 'name ASC'),
                        'named' => array('от Я до А', 'name DESC')
                        );
        $order_get = clear($_GET['order']); // получаем возможный параметр сортировки
        if(array_key_exists($order_get, $order_p)){
            $order = $order_p[$order_get][0];
            $order_db = $order_p[$order_get][1];
        }else{
            // по умолчанию сортировка по первому элементу массива order_p
            $order = $order_p['namea'][0];
            $order_db = $order_p['namea'][1];
        }
        /* =====Сортировка===== */
        // параметры для навигации
        $perpage = PERPAGE; // кол-во товаров на страницу
        if(isset($_GET['page'])){
            $page = (int)$_GET['page'];
            if($page < 1) $page = 1;
        }else{
            $page = 1;
        }
		$visible = 1;
		if(isset($_GET['cher'])){
			$visible = 0;
		}
		$site_id = $_SESSION['auth']['site_id'];
        $count_rows = count_rows("site_id", $site_id, $visible); // общее кол-во товаров
		if ($visible) {
			$count_rows_v = $count_rows;
			$count_rows_c = count_rows("site_id", $site_id, 0);
		}else{
			$count_rows_c = $count_rows;
			$count_rows_v = count_rows("site_id", $site_id, 1);
		}
		
        $pages_count = ceil($count_rows / $perpage); // кол-во страниц
        if(!$pages_count) $pages_count = 1; // минимум 1 страница
        if($page > $pages_count) $page = $pages_count; // если запрошенная страница больше максимума
        $start_pos = ($page - 1) * $perpage; // начальная позиция для запроса
        $products = products_by_site($site_id , $order_db, $start_pos, $perpage, $visible); // получаем массив из модели
		$show_right_panel=False;
    break;

    case('user/shop/add_product'):
        if($_POST){
            if(add_product()) redirect("?view=user/shop/shop");
                else redirect();
		} else {
			// получение массива каталога
			$cat_e = get_catalog_by_parent(2,0); //Получаем родительские категории для группы товары
        }
		$show_right_panel=False;
    break;

    case('user/shop/edit_product'):
        $goods_id = (int)$_GET['goods_id'];
        $get_product = get_product($goods_id);
		//Проверка на право редактирования товара по данному сайту
		if ($_SESSION['auth']['site_id']<>$get_product['site_id']) {
			redirect('/');
		}
		$cat_e = get_catalog_by_parent(2,0); //Получаем родительские категории для группы товары
		$parent_id = $get_product['parent_id'];
		//Подключаем изображения к товару
		$goods_pic = get_goods_pic($goods_id);
	

        if($_POST){
            if(edit_product($goods_id)) redirect("?view=user/shop/shop");
                else redirect();
        }
		$show_right_panel=False;
    break;

    case('test'):
    break;

	
    default:
        // если из адресной строки получено имя несуществующего вида
        $view = 'home';
        //$eyestoppers = eyestopper('hits');
}

	//Если включена видимость правой панели, то получаем данные
	if ($show_right_panel) {
        /* =====Сортировка===== */
        $order_db = 'date DESC';
        // параметры для навигации
        $perpage = 6; // кол-во товаров на страницу

        $start_pos = 0; // начальная позиция для запроса
        $products_new = products_by_site(0 , $order_db, $start_pos, $perpage); // получаем массив из модели
	
	}

// подключение вида
require_once $_SERVER['DOCUMENT_ROOT'].'/views/wood/index.php'; // http://ishop/views/ishop/index.php