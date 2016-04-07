<?php

// запрет прямого обращения
define('WOOD', TRUE);

session_start();

if($_GET['do'] == "logout"){
    unset($_SESSION['auth']);
}

if(!$_SESSION['auth']['admin']){
   // подключение авторизации
   include $_SERVER['DOCUMENT_ROOT'].'/admin/auth/index.php';
}

// подключение файла конфигурации
require_once '../config.php';

// подключение файла функций пользовательской части
require_once '../functions/functions.php';

// подключение файла функций административной части
require_once 'functions/functions.php';

// получение количества необработанных заказов
$count_new_orders = count_new_orders();

// загрузка картинок AjaxUpload
if($_POST['id']){
    $id = (int)$_POST['id'];
    upload_gallery_img($id);
}

// загрузка списка строк для row_id в зависимости от tabl_nam
if($_POST['ajax']){
 if($_POST['tabl_n']){
	switch($_POST['tabl_n']){
		case('page'):
			// страницы
			$pages = pages();        
		break;    
		case('galery'):
			// галереи
			$pages = pages();        
		break;    
	$id = (int)$_POST['id'];
    upload_gallery_img($id);
	}
 }
}

// удаление картинок
if($_POST['img']){
    $res = del_img();
    exit($res);
}

// сортировка страниц
if($_POST['sortable']) {
	
	$result = sort_pages($_POST['sortable']);
	if(!$result) {
		exit(FALSE);
	}
	
	exit(json_encode($result));
}

//сортировка ссылок
if($_POST['sort_link']) {
	
	//проверяем есть ли идентификатор информера к которому принадлежат ссылки
	if(array_key_exists('parent',$_POST)) {
		$parent = $_POST['parent'];
		unset($_POST['parent']);
	}
	else {
		exit(FALSE);
	}
	
	$result = sort_links($_POST['sort_link'],$parent);
	if(!$result) {
		exit(FALSE);
	}
	exit(json_encode($result));
}

//сортировка информеров
if($_POST['sort_inf']) {
	
	$result = sort_informers($_POST['sort_inf'],$parent);
	if(!$result) {
		exit(FALSE);
	}
	exit(TRUE);
}

// получение массива каталога
$cat = catalog(); 

// получение динамичной части шаблона #content
$view = empty($_GET['view']) ? 'pages' : $_GET['view'];

switch($view){
    case('pages'):
        // страницы
        $pages = pages();        
    break;
    
    case('groups'):
        // Группы категорий
        $group = groups();
    break;

    case('galerys'):
        // Список галерей
        $galerys = galerys();
    break;

    case('edit_galery'):
        // Галерея
		$galery_id = (int)$_GET['galery_id'];
        $galery = get_galery($galery_id);
        $files = get_galery_files($galery_id);
    break;
    
    case('informers'):
        // информеры
        $informers = informer();
    break;
    
    case('edit_page'):
        // редактирование страницы
        $page_id = (int)$_GET['page_id'];
        $get_page = get_page($page_id);
        
        if($_POST){
            if(edit_page($page_id)) redirect('?view=pages');
                else redirect();
        }
    break;
    
    case('add_page'):
        if($_POST){
            if(add_page()) redirect('?view=pages');
                else redirect();
        }
    break;
    
    case('del_page'):
        $page_id = (int)$_GET['page_id'];
        del_page($page_id);
        redirect();
    break;
    
    case('news'):
        // все новости (архив новостей)
        // параметры для навигации
        $perpage = PERPAGE; // кол-во товаров на страницу
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
        
        $all_news = get_all_news($start_pos, $perpage);
    break;
    
    case('add_news'):
		$get_news_type = get_news_type();
        if($_POST){
            if(add_news()) redirect('?view=news');
                else redirect();
        }
    break;
    
    case('edit_news'):
        $news_id = (int)$_GET['news_id'];
        $get_news = get_news($news_id);
		$get_news_type = get_news_type();
        if($_POST){
            if(edit_news($news_id)) redirect('?view=news');
                else redirect();
        }
    break;
    
    case('del_news'):
        $news_id = (int)$_GET['news_id'];
        del_news($news_id);
        redirect();
    break;
    
    case('add_link'):
        $informer_id = (int)$_GET['informer_id'];
        $informers = get_informers(); // список информеров
        if($_POST){
            if(add_link()) redirect('?view=informers');
                else redirect();
        }
    break;
    
    case('edit_link'):
        $link_id = (int)$_GET['link_id'];
        $informers = get_informers(); // список информеров
        $get_link = get_link($link_id);
        if($_POST){
            if(edit_link($link_id)) redirect('?view=informers');
                else redirect();
        }
    break;
    
    case('del_link'):
        $link_id = (int)$_GET['link_id'];
        del_link($link_id);
        redirect();
    break;
    
    case('add_informer'):
        if($_POST){
            if(add_informer()) redirect('?view=informers');
                else redirect();
        }
    break;
    
    case('del_informer'):
        $informer_id = (int)$_GET['informer_id'];
        del_informer($informer_id);
        redirect();
    break;
    
    case('edit_informer'):
        $informer_id = (int)$_GET['informer_id'];
        $get_informer = get_informer($informer_id);
        if($_POST){
            if(edit_informer($informer_id)) redirect('?view=informers');
                else redirect();
        }
    break;
    
    case('category'):
    break;

    case('categorys'):
        if(isset($_GET['p_id'])){
            $parent_id = (int)$_GET['p_id'];
        }else{
            $parent_id = 0;
        }
		$category_group = get_category_group(); // Получаем список групп категорий
		if(!isset($_COOKIE['group_id'])) {
			$group_id = 1;
		} else {
			$group_id = $_COOKIE['group_id'];
		}
		$categorys = get_categorys_by_parent($group_id, $parent_id); //Получаем список категорий по родительской категории
		$pparent = get_parent_category_by_cat($parent_id); //Получаем родителя родительской категории
    break;
    
    case('add_category'):
		$category_group = get_category_group(); // Получаем список групп категорий
		$pages = pages(); // Получение списка страниц
        if($_POST){
            if(add_category()) redirect('?view=categorys');
                else redirect();
        }
    break;
    
    case('edit_category'):
        $cat_id = (int)$_GET['cat_id'];
        if($_POST){
			$parent_id = (int)$_POST['parent_id'];
            if($parent_id AND edit_category($cat_id)){
                redirect("?view=categorys&p_id=$parent_id");
            }elseif(edit_category($cat_id)){
                redirect('?view=categorys');
            }else{
                redirect();
            }
        }

        $parent_id = (int)$_GET['parent_id'];
		$group_id = (int)$_GET['parent_id'];
        //$cat_name = $cat[$cat_id][0];
		
		$category = get_category($cat_id); // Получение даныых конкретной категории
		$category_group = get_category_group(); // Получаем список групп категорий
		$pages = pages(); // Получение списка страниц
        if($parent_id == $cat_id OR !$parent_id){
            // если родительская категория
            $cat_name = $cat[$cat_id][0];
        }else{
            // если дочерняя категория
            $cat_name = $cat[$parent_id]['sub'][$cat_id];
        }
    break;
    
    case('del_category'):
        $cat_id = (int)$_GET['cat_id'];
        del_category($cat_id);
        redirect();
    break;
    
    case('cat'):
        $category = (int)$_GET['category'];
        
        /*pagination*/
        $perpage = 6;
        if(isset($_GET['page'])){
            $page = (int)$_GET['page'];
            if($page < 1) $page = 1;
        }else{
            $page = 1;
        }
        $count_rows = count_rows($category); // общее кол-во товаров
        $pages_count = ceil($count_rows / $perpage); // кол-во страниц
        if(!$pages_count) $pages_count = 1; // минимум 1 страница
        if($page > $pages_count) $page = $pages_count; // если запрошенная страница больше максимума
        $start_pos = ($page - 1) * $perpage; // начальная позиция для запроса
        /*pagination*/
        
        $cat_name = cat_name($category); // хлебные крохи
        $products = products($category, $start_pos, $perpage); // получаем массив из модели
    break;
    
    case('add_product'):
        $cat_id = (int)$_GET['cat_id'];
        if($_POST){
            if(add_product()) redirect("?view=cat&category=$cat_id");
                else redirect();
        }
    break;
    
    case('edit_product'):
        $goods_id = (int)$_GET['goods_id'];
        $get_product = get_product($goods_id);
        $cat_id = $get_product['goods_catid'];
        // если есть базовая картинка
        if($get_product['img'] != "no_image.jpg"){
            $baseimg = '<img class="delimg" rel="0" width="48" src="' .PRODUCTIMG.$get_product['img']. '" alt="' .$get_product['img']. '">';
        }else{
            $baseimg = '<input type="file" name="baseimg" />';
        }
        // если есть картинки галереи
        $imgslide = "";
        if($get_product['img_slide']){
            $images = explode("|", $get_product['img_slide']);
            foreach($images as $img){
                $imgslide .= "<img class='delimg' rel='1' alt='{$img}' src='" .GALLERYIMG. "thumbs/{$img}'>";
            }
        }
        if($_POST){
            if(edit_product($goods_id)) redirect("?view=cat&category=$cat_id");
                else redirect();
        }
    break;
    
    case('orders'):
        // подтверждение заказа
        if(isset($_GET['confirm'])){
            $order_id = (int)$_GET['confirm'];
            if(confirm_order($order_id)){
                $_SESSION['answer'] = "<div class='success'>Статус заказа №{$order_id} успешно изменен.</div>";
            }else{
                $_SESSION['answer'] = "<div class='error'>Статус заказа №{$order_id} не удалось изменить. Возможно, заказа с таким номером нет или он уже подтвержден.</div>";
            }
            redirect("?view=orders&status=0");
        }
        
        // удаление заказа
        if(isset($_GET['del_order'])){
            $order_id = (int)$_GET['del_order'];
            if(del_order($order_id)){
                $_SESSION['answer'] = "<div class='success'>Заказ удален.</div>";
            }else{
                $_SESSION['answer'] = "<div class='error'>Ошибка! Возможно этот заказ был уже удален.</div>";
            }
            redirect("?view=orders");
        }
        
        if($_GET['status'] === '0'){
            $status = " WHERE orders.status = '0'";
        }else{
            $status = null;
        }
        // параметры для навигации
        $perpage = 2; // кол-во товаров на страницу
        if(isset($_GET['page'])){
            $page = (int)$_GET['page'];
            if($page < 1) $page = 1;
        }else{
            $page = 1;
        }
        $count_rows = count_orders($status); // общее кол-во заказов
        $pages_count = ceil($count_rows / $perpage); // кол-во страниц
        if(!$pages_count) $pages_count = 1; // минимум 1 страница
        if($page > $pages_count) $page = $pages_count; // если запрошенная страница больше максимума
        $start_pos = ($page - 1) * $perpage; // начальная позиция для запроса
        
        $orders = orders($status, $start_pos, $perpage);
    break;
    
    case('show_order'):
        $order_id = (int)$_GET['order_id'];
        $show_order = show_order($order_id);
        if($show_order[0]['status']){
            $state = "обработан";
        }else{
            $state = "не обработан";
        }
    break;
    
    case('users'):
        // параметры для навигации
        $perpage = 5; // кол-во товаров на страницу
        if(isset($_GET['page'])){
            $page = (int)$_GET['page'];
            if($page < 1) $page = 1;
        }else{
            $page = 1;
        }
        $count_rows = count_users(); // общее кол-во пользователей
        $pages_count = ceil($count_rows / $perpage); // кол-во страниц
        if(!$pages_count) $pages_count = 1; // минимум 1 страница
        if($page > $pages_count) $page = $pages_count; // если запрошенная страница больше максимума
        $start_pos = ($page - 1) * $perpage; // начальная позиция для запроса
        
        $users = get_users($start_pos, $perpage);
    break;
    
    case('add_user'):
        $roles = get_roles();
        if($_POST){
            if(add_user()) redirect("?view=users");
                else redirect();
        }
    break;
    
    case('edit_user'):
        $user_id = (int)$_GET['user_id'];
        $get_user = get_user($user_id);
        $roles = get_roles();
        if($_POST){
            if(edit_user($user_id)) redirect("?view=users");
                else redirect();
        }
    break;
    
    case('del_user'):
        $user_id = (int)$_GET['user_id'];
        del_user($user_id);
        redirect();
    break;
    
	case('add_file'):
		if (isset($_GET['galery_id'])) {$galery_id=$_GET['galery_id'];}
        if($_POST){
            if(add_file()) redirect("?view=edit_galery&galery_id=$galery_id");
                else redirect();
        }
    break;

	case('del_file'):
		if (isset($_GET['file_id'])) {$file_id=$_GET['file_id'];}
        del_file($file_id);
        redirect();
    break;
	
    default:
    // если из адресной строки получено имя несуществующего вида
    $view = 'pages'; 
    $pages = pages();  
}

// HEADER
include ADMIN_TEMPLATE.'header.php';

// LEFTBAR
include ADMIN_TEMPLATE.'leftbar.php';

// CONTENT
include ADMIN_TEMPLATE.$view.'.php';

?>