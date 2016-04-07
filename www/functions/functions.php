<?php

defined('WOOD') or die('Access denied');

/* ===Распечатка массива=== */
function print_arr($arr){
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}
/* ===Распечатка массива=== */

/* ===Фильтрация входящих данных из админки=== */
function clear_admin($var){
    $var = mysql_real_escape_string($var);
    return $var;
}
/* ===Фильтрация входящих данных из админки=== */
/* ===Фильтрация входящих данных=== */
function clear($var){
    $var = mysql_real_escape_string(strip_tags($var));
    return $var;
}
/* ===Фильтрация входящих данных=== */

/* ===Редирект=== */
function redirect($http = false){
    if($http) $redirect = $http;
        else    $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;
    header("Location: $redirect");
    exit;
}
/* ===Редирект=== */

/* ===Выход пользователя=== */
function logout(){
    unset($_SESSION['auth']);
}
/* ===Выход пользователя=== */

/* ===Добавление в корзину=== */
function addtocart($goods_id, $qty = 1){
    if(isset($_SESSION['cart'][$goods_id])){
        // если в массиве cart уже есть добавляемый товар
        $_SESSION['cart'][$goods_id]['qty'] += $qty;
        return $_SESSION['cart'];
    }else{
        // если товар кладется в корзину впервые
        $_SESSION['cart'][$goods_id]['qty'] = $qty;
        return $_SESSION['cart'];
    }
}
/* ===Добавление в корзину=== */

/* ===Удаление из корзины=== */
function delete_from_cart($id){
    if($_SESSION['cart']){
        if(array_key_exists($id, $_SESSION['cart'])){
            $_SESSION['total_quantity'] -= $_SESSION['cart'][$id]['qty'];
            $_SESSION['total_sum'] -= $_SESSION['cart'][$id]['qty'] * $_SESSION['cart'][$id]['price'];
            unset($_SESSION['cart'][$id]);
        }
    }
}
/* ===Удаление из корзины=== */

/* ===кол-во товара в корзине + защита от ввода несуществующего ID товара=== */
function total_quantity(){
    $_SESSION['total_quantity'] = 0;
    foreach($_SESSION['cart'] as $key => $value){
        if(isset($value['price'])){
            // если получена цена товара из БД - суммируем кол-во
            $_SESSION['total_quantity'] += $value['qty'];
        }else{
            // иначе - удаляем такой ID из сессиии (корзины)
            unset($_SESSION['cart'][$key]);
        }
    }
}
/* ===кол-во товара в корзине + защита от ввода несуществующего ID товара=== */

/* ===Постраничная навигация=== */
function pagination($page, $pages_count, $modrew = 1){
    if($modrew == 0){
        // если функция вызывается на странице без ЧПУ
        if($_SERVER['QUERY_STRING']){ // если есть параметры в запросе
            $uri = "?";
            foreach($_GET as $key => $value){
                // формируем строку параметров без номера страницы... номер передается параметром функции
               if($key != 'page') $uri .= "{$key}={$value}&amp;";
            }  
        }   
    }else{
        // если функция вызвана на странице с ЧПУ
        $uri = $_SERVER['REQUEST_URI'];
        $params = explode("/", $uri);;
        $uri = null;
        foreach($params as $param){
            if(!empty($param) AND !preg_match("#page=#", $param)){
                $uri .= "/$param";
            }
        }
        $uri .= "/";
    }
    
    
    // формирование ссылок
    $back = ''; // ссылка НАЗАД
    $forward = ''; // ссылка ВПЕРЕД
    $startpage = ''; // ссылка В НАЧАЛО
    $endpage = ''; // ссылка В КОНЕЦ
    $page2left = ''; // вторая страница слева
    $page1left = ''; // первая страница слева
    $page2right = ''; // вторая страница справа
    $page1right = ''; // первая страница справа
    
    if($page > 1){
        $back = "<a class='nav_link' href='{$uri}page=" .($page-1). "'>&lt;</a>";
    }
    if($page < $pages_count){
        $forward = "<a class='nav_link' href='{$uri}page=" .($page+1). "'>&gt;</a>";
    }
    if($page > 3){
        $startpage = "<a class='nav_link' href='{$uri}page=1'>&laquo;</a>";
    }
    if($page < ($pages_count - 2)){
        $endpage = "<a class='nav_link' href='{$uri}page={$pages_count}'>&raquo;</a>";
    }
    if($page - 2 > 0){
        $page2left = "<a class='nav_link' href='{$uri}page=" .($page-2). "'>" .($page-2). "</a>";
    }
    if($page - 1 > 0){
        $page1left = "<a class='nav_link' href='{$uri}page=" .($page-1). "'>" .($page-1). "</a>";
    }
    if($page + 2 <= $pages_count){
        $page2right = "<a class='nav_link' href='{$uri}page=" .($page+2). "'>" .($page+2). "</a>";
    }
    if($page + 1 <= $pages_count){
        $page1right = "<a class='nav_link' href='{$uri}page=" .($page+1). "'>" .($page+1). "</a>";
    }
    
    // формируем вывод навигации
    echo '<div class="pagination">' .$startpage.$back.$page2left.$page1left.'<a class="nav_active">'.$page.'</a>'.$page1right.$page2right.$forward.$endpage. '</div>';
}
/* ===Постраничная навигация=== */


/* ===Отправка почты=== */

function s_mail($from_email, $from_name, $body){
// Подключаем класс FreakMailer
	require_once($_SERVER['DOCUMENT_ROOT'].'/lib/phpmailer/MailClass.inc');// Подключаем класс FreakMailer

	$mailer = new FreakMailer();						// инициализируем класс
	$mailer->setFrom($from_email, $from_name);			// Добавляем отправителя письма
	$mailer->Subject = 'Сообщение с сайта '.TITLE;		// Устанавливаем тему письма
	$mailer->Body = $body;								// Задаем тело письма
	// Добавляем адрес в список получателей
	$mailer->AddAddress(ADMIN_EMAIL, TITLE);

	if(!$mailer->Send()) {
	  $_SESSION['mess']['res'] = "<div class='error'>Ошибка оправления письма.\r\n".$mailer->ErrorInfo." </div>";		
	}else {
	  $_SESSION['mess']['res'] = "<div class='success'>Ваше письмо успешно отправлено.</div>";
	}
	$mailer->ClearAddresses();
	$mailer->ClearAttachments();
	$status="success";
	$message = 'Ok.';
}
/* ===Отправка почты=== */
/* ===Генерация случайной строки=== */
function generateString($length = 6){
  $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ123456789';
  $numChars = strlen($chars);
  $string = '';
  for ($i = 0; $i < $length; $i++) {
    $string .= substr($chars, rand(1, $numChars) - 1, 1);
  }
  return $string;
}
/* ===Генерация случайной строки=== */
/* ===Создание папки на сервере=== */
function createFolder($path){
	$error=0;
	if (file_exists($path)) {
	   $error=1; //такая папка существует
	} else {
		if (!mkdir($path, 0700, true)) {
			$error=2; //не удалось создать папку
		}
	}
	return $error;
}

/* ===Создание папки на сервере=== */
/* ===Генерация имени структуры папок для нового пользователя=== */
function generateFolder(){
	$error=0;
	$m_path=generateString();
	$filename = USERFILES . $m_path . '/' . USERFILES_PRODUCTIMG;
	return $filename;
}
/* ===Генерация имени структуры папок для нового пользователя=== */

/* ===Ресайз картинок=== */
function resize($target, $dest, $wmax, $hmax, $ext){
    /*
    $target - путь к оригинальному файлу
    $dest - путь сохранения обработанного файла
    $wmax - максимальная ширина
    $hmax - максимальная высота
    $ext - расширение файла
    */
    list($w_orig, $h_orig) = getimagesize($target);
    $ratio = $w_orig / $h_orig; // =1 - квадрат, <1 - альбомная, >1 - книжная

    if(($wmax / $hmax) > $ratio){
        $wmax = $hmax * $ratio;
    }else{
        $hmax = $wmax / $ratio;
    }
    
    $img = "";
    // imagecreatefromjpeg | imagecreatefromgif | imagecreatefrompng
    switch($ext){
        case("gif"):
            $img = imagecreatefromgif($target);
            break;
        case("png"):
            $img = imagecreatefrompng($target);
            break;
        default:
            $img = imagecreatefromjpeg($target);    
    }
    $newImg = imagecreatetruecolor($wmax, $hmax); // создаем оболочку для новой картинки
    
    if($ext == "png"){
        imagesavealpha($newImg, true); // сохранение альфа канала
        $transPng = imagecolorallocatealpha($newImg,0,0,0,127); // добавляем прозрачность
        imagefill($newImg, 0, 0, $transPng); // заливка  
    }
    
    imagecopyresampled($newImg, $img, 0, 0, 0, 0, $wmax, $hmax, $w_orig, $h_orig); // копируем и ресайзим изображение
    switch($ext){
        case("gif"):
            imagegif($newImg, $dest);
            break;
        case("png"):
            imagepng($newImg, $dest);
            break;
        default:
            imagejpeg($newImg, $dest);    
    }
    imagedestroy($newImg);
}
/* ===Ресайз картинок=== */


//You do not need to alter these functions
function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
	list($imagewidth, $imageheight, $imageType) = getimagesize($image);
	$imageType = image_type_to_mime_type($imageType);
	
	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
	switch($imageType) {
		case "image/gif":
			$source=imagecreatefromgif($image); 
			break;
	    case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
			$source=imagecreatefromjpeg($image); 
			break;
	    case "image/png":
		case "image/x-png":
			$source=imagecreatefrompng($image); 
			break;
  	}
	imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
	switch($imageType) {
		case "image/gif":
	  		imagegif($newImage,$thumb_image_name); 
			break;
      	case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
	  		imagejpeg($newImage,$thumb_image_name,90); 
			break;
		case "image/png":
		case "image/x-png":
			imagepng($newImage,$thumb_image_name);  
			break;
    }
	chmod($thumb_image_name, 0777);
	return $thumb_image_name;
}








