<?php

defined('WOOD') or die('Access denied');

/* ====Каталог - получение массива=== */
function catalog($group_id){
	$query = "CREATE TEMPORARY TABLE `temp2`
	SELECT category.*,
				(SELECT count(*) FROM goods where goods_catid = category.cat_id and `visible`='1' ) as kol
				FROM category
				WHERE group_id = $group_id";
    $res = mysql_query($query) or die(mysql_query());				
	$query = "	CREATE TEMPORARY TABLE `temp3`
				select parent_id, sum(kol) as kol from `temp2` group by parent_id";
	$res = mysql_query($query) or die(mysql_query());	
	$query = "UPDATE temp2 
				inner join temp3 on temp2.cat_id = temp3.parent_id
				set temp2.kol = temp3.kol";
	$res = mysql_query($query) or die(mysql_query());					
	$query = "			SELECT * from `temp2` ORDER BY cat_name, position";
	$res = mysql_query($query) or die(mysql_query());		
	
	
    //$query = "SELECT * FROM category WHERE group_id = $group_id ORDER BY cat_name, position";
    $res = mysql_query($query) or die(mysql_query());
    
	//массив категорий
    $cat = array();
    while($row = mysql_fetch_assoc($res)){
        if(!$row['parent_id']){
            $cat[$row['cat_id']][] = $row['cat_name']. " (". $row['kol']. ")";
        }else{
            $cat[$row['parent_id']]['sub'][$row['cat_id']] = $row['cat_name']. " (". $row['kol']. ")";
        }
    }
    return $cat;

    //массив категорий
/*     $cat = array();
    while($row = mysql_fetch_assoc($res)){
        if(!$row['parent_id']){
            $cat[$row['cat_id']][] = $row['cat_name'];
            $cat[$row['cat_id']]['tabl_nam'] = $row['tabl_nam'];
            $cat[$row['cat_id']]['row_id'] = $row['row_id'];
			}else{
            $cat[$row['parent_id']]['sub'][$row['cat_id']][] = $row['cat_name'];
            $cat[$row['parent_id']]['sub'][$row['cat_id']]['tabl_nam'] = $row['tabl_nam'];
            $cat[$row['parent_id']]['sub'][$row['cat_id']]['row_id'] = $row['row_id'];
        }
    }
    return $cat; */
}
/* ====Каталог - получение массива=== */

/* ====Каталог - получение массива по parent_id=== */
function get_catalog_by_parent($group_id, $parent_id){
    $query = "SELECT * FROM category WHERE group_id = $group_id and parent_id = $parent_id ORDER BY position";
    $res = mysql_query($query) or die(mysql_query());
    
    //массив категорий
    $items = array();
    while($row = mysql_fetch_assoc($res)){
        $items[] = $row;
    }
    return $items;
}
/* ====Каталог - получение массива по parent_id=== */

/* ===Галереи=== */
function galerys(){
    $query = "SELECT * FROM galerys ORDER BY position";
    $res = mysql_query($query);
    
    $items = array();
    while($row = mysql_fetch_assoc($res)){
        $items[] = $row;
    }
    return $items;
}
/* ===Галереи=== */

/* ===Страницы=== */
function pages(){
    $query = "SELECT page_id, title FROM pages ORDER BY position";
    $res = mysql_query($query);
    
    $pages = array();
    while($row = mysql_fetch_assoc($res)){
        $pages[] = $row;
    }
    return $pages;
}
/* ===Страницы=== */

/* ===Отдельная страница=== */
function get_page($page_id){
    $query = "SELECT * FROM pages WHERE page_id = $page_id";
    $res = mysql_query($query);
    
    $get_page = array();
    $get_page = mysql_fetch_assoc($res);
    return $get_page;
}
/* ===Отдельная страница=== */

/* ===Главная страница=== */
function get_page_home(){
    $query = "SELECT * FROM pages WHERE home = 1 limit 1";
    $res = mysql_query($query);
    
    $get_page = array();
    $get_page = mysql_fetch_assoc($res);
    return $get_page;
}
/* ===Главная страница=== */

/* ===Названия новостей=== */
function get_title_news($type_id=0){
	$where = "";
	if ($type_id>0) $where = " WHERE type_id = " . $type_id;
    $query = "SELECT news_id, title, anons, date FROM news $where ORDER BY date DESC LIMIT ".NEWSLIST;
    $res = mysql_query($query);
    
    $items = array();
    while($row = mysql_fetch_assoc($res)){
        $items[] = $row;
    }
    return $items;
}
/* ===Названия новостей=== */

/* ===Отдельная новость=== */
function get_news_text($news_id){
    $query = "SELECT title, text, date FROM news WHERE news_id = $news_id";
    $res = mysql_query($query);
    
    $news_text = array();
    $news_text = mysql_fetch_assoc($res);
    return $news_text;
}
/* ===Отдельная новость=== */

/* ===Архив новостей=== */
function get_all_news($start_pos, $perpage,$type_id=0){
	$where = "";
	if ($type_id>0) $where = " WHERE type_id = " . $type_id;
    $query = "SELECT news_id, title, anons, date FROM news $where ORDER BY date DESC LIMIT $start_pos, $perpage";
    $res = mysql_query($query);
    
    $all_news = array();
    while($row = mysql_fetch_assoc($res)){
        $all_news[] = $row;
    }
    return $all_news;
}
/* ===Архив новостей=== */

/* ===Количество новостей=== */
function count_news(){
    $query = "SELECT COUNT(news_id) FROM news";
    $res = mysql_query($query);
    
    $count_news = mysql_fetch_row($res);
    return $count_news[0];
}
/* ===Количество новостей=== */

/* ===Информеры - получение массива=== */
function informer(){
    $query = "SELECT * FROM links
                INNER JOIN informers ON
                    links.parent_informer = informers.informer_id
                        ORDER BY informer_position, links_position";
    $res = mysql_query($query) or die(mysql_query());
    
    $informers = array();
    $name = ''; // флаг имени информера
    while($row = mysql_fetch_assoc($res)){
        if($row['informer_name'] != $name){ // если такого информера в массиве еще нет
            $informers[$row['informer_id']][] = $row['informer_name']; // добавляем информер в массив
            $name = $row['informer_name'];
        }
        $informers[$row['parent_informer']]['sub'][$row['link_id']] = $row['link_name']; // заносим страницы в информер
    }
    return $informers;
}
/* ===Информеры - получение массива=== */

/* ===Получение текста информера=== */
function get_text_informer($informer_id){
    $query = "SELECT link_id, link_name, text, informers.informer_id, informers.informer_name
                FROM links
                    LEFT JOIN informers ON informers.informer_id = links.parent_informer
                        WHERE link_id = $informer_id";
    $res = mysql_query($query);
    
    $text_informer = array();
    $text_informer = mysql_fetch_assoc($res);
    return $text_informer;
}
/* ===Получение текста информера=== */

/* ===Айстопперы - новинки, лидеры продаж, распродажа=== */
function eyestopper($eyestopper){
    $query = "SELECT goods_id, name, img, price FROM goods
                WHERE visible='1' AND $eyestopper='1'";
    $res = mysql_query($query) or die(mysql_error());
    
    $eyestoppers = array();
    while($row = mysql_fetch_assoc($res)){
        $eyestoppers[] = $row;
    }
    
    return $eyestoppers;
}
/* ===Айстопперы - новинки, лидеры продаж, распродажа=== */

/* ===Получение кол-ва товаров для навигации=== */
function count_rows($field_nam, $field_val = 0, $visible = '1'){
	$m_Where = " WHERE visible='$visible'";
	$count_rows = 0;
	if ($field_nam<>'none') {
		$m_Where = $m_Where ." AND " . $field_nam ." = " . $field_val  ;
	}
    $query = "SELECT COUNT(goods_id) as count_rows
                 FROM goods 
				 INNER JOIN category ON goods.goods_catid = category.cat_id 
				 " . $m_Where;
    $res = mysql_query($query) or die(mysql_error());
    
    while($row = mysql_fetch_assoc($res)){
        if($row['count_rows']) $count_rows = $row['count_rows'];
    }
    return $count_rows;
}
/* ===Получение кол-ва товаров для навигации=== */

/* ===Получение массива товаров по категории=== */
function products($category, $order_db, $start_pos, $perpage){
    $query = "(SELECT goods_id, name, img, anons, price, hits, new, sale, date, sites.site_title, valuta.val_abr,
				IFNULL((SELECT CONCAT(pic_path,'t_',pic_name) FROM goods_pic where goods_id = goods.goods_id and glav='1' ),'".TEMPLATE."images/noimg.png') as pic
                 FROM goods
				INNER JOIN sites ON goods.site_id = sites.site_id 
				INNER JOIN valuta ON sites.val_id = valuta.val_id 
				WHERE goods_catid = $category AND visible='1')
               UNION      
               (SELECT goods_id, name, img, anons, price, hits, new, sale, date, sites.site_title, valuta.val_abr,
				IFNULL((SELECT CONCAT(pic_path,'t_',pic_name) FROM goods_pic where goods_id = goods.goods_id and glav='1' ),'".TEMPLATE."images/noimg.png') as pic
                 FROM goods 
				INNER JOIN sites ON goods.site_id = sites.site_id 
				INNER JOIN valuta ON sites.val_id = valuta.val_id 
				WHERE goods_catid IN 
                (
                    SELECT cat_id FROM category WHERE parent_id = $category
                ) AND visible='1') ORDER BY $order_db LIMIT $start_pos, $perpage";
    $res = mysql_query($query) or die(mysql_error());
    
    $products = array();
    while($row = mysql_fetch_assoc($res)){
        $products[] = $row;
    }
    
    return $products;
}
/* ===Получение массива товаров по категории=== */
/* ===Получение массива товаров по сайту=== */
function products_by_site($site_id, $order_db, $start_pos, $perpage, $visible='1'){
	$m_Where = " WHERE visible='$visible'";
	if ($site_id<>0) {
		$m_Where = $m_Where ." AND goods.site_id = $site_id  ";
	}
    $query = "SELECT goods.*, sites.site_title, valuta.val_abr, 
				IFNULL((SELECT CONCAT(pic_path,'t_',pic_name) FROM goods_pic where goods_id = goods.goods_id and glav='1' ),'".PATH.TEMPLATE."images/noimg.png') as pic
				FROM goods
				INNER JOIN sites ON goods.site_id = sites.site_id 
				INNER JOIN valuta ON sites.val_id = valuta.val_id 
				" . $m_Where .
				" ORDER BY $order_db LIMIT $start_pos, $perpage";
	$res = mysql_query($query) or die(mysql_error() );
    $products = array();
    while($row = mysql_fetch_assoc($res)){
        $products[] = $row;
    }
    
    return $products;
}
/* ===Получение массива товаров по сайту=== */
/* ===Получение названий для хлебных крох=== */
function cat_name($category){
    $query = "(SELECT cat_id, cat_name FROM category
                WHERE cat_id = 
                    (SELECT parent_id FROM category WHERE cat_id = $category)
                )
                UNION
                    (SELECT cat_id, cat_name FROM category WHERE cat_id = $category)";
    $res = mysql_query($query);
    $cat_name = array();
    while($row = mysql_fetch_assoc($res)){
        $cat_name[] = $row;
    }
    return $cat_name;
}
/* ===Получение названий для хлебных крох=== */

/* ===Выбор по параметрам=== */
function filter($category, $startprice, $endprice){
    $products = array();
    if($category OR $endprice){
        $predicat1 = "visible='1'";
        if($category){
            $predicat1 .= " AND goods_catid IN($category)";
            $predicat2 = "UNION
                        (SELECT goods_id, name, img, price, hits, new, sale
                        FROM goods
                            WHERE goods_catid IN
                            (
                                SELECT cat_id FROM category WHERE parent_id IN($category)
                            ) AND visible='1'";
            if($endprice) $predicat2 .= " AND price BETWEEN $startprice AND $endprice";
            $predicat2 .= ")";
        }
        if($endprice){
            $predicat1 .= " AND price BETWEEN $startprice AND $endprice";
        }
        
        $query = "(SELECT goods_id, name, img, price, hits, new, sale
                    FROM goods
                        WHERE $predicat1)
                         $predicat2 ORDER BY name";
        $res = mysql_query($query) or die(mysql_error());
        if(mysql_num_rows($res) > 0){
            while($row = mysql_fetch_assoc($res)){
                $products[] = $row;
            }
        }else{
            $products['notfound'] = "<div class='error'>По указанным параметрам ничего не найдено</div>";
        }       
    }else{
        $products['notfound'] = "<div class='error'>Вы не указали параметры подбора</div>";
    }
    return $products;
}
/* ===Выбор по параметрам=== */

/* ===Сумма заказа в корзине + атрибуты товара===*/
function total_sum($goods){
    $total_sum = 0;
    
    $str_goods = implode(',',array_keys($goods));
    
    $query = "SELECT goods_id, name, price, 
				IFNULL((SELECT CONCAT(pic_path,'t_',pic_name) FROM goods_pic where goods_id = goods.goods_id and glav='1' ),'".PATH.TEMPLATE."images/noimg.png') as img
                FROM goods
                    WHERE goods_id IN ($str_goods)";
    $res = mysql_query($query) or die(mysql_error());
    
    while($row = mysql_fetch_assoc($res)){
        $_SESSION['cart'][$row['goods_id']]['name'] = $row['name'];
        $_SESSION['cart'][$row['goods_id']]['price'] = $row['price'];
        $_SESSION['cart'][$row['goods_id']]['img'] = $row['img'];
        $total_sum += $_SESSION['cart'][$row['goods_id']]['qty'] * $row['price'];
    }
    return $total_sum;
}
/* ===Сумма заказа в корзине + атрибуты товара===*/

/* ===Регистрация=== */
function registration(){
    $error = ''; // флаг проверки пустых полей
    
    $login = trim($_POST['login']);
    $pass = trim($_POST['pass']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    
    if(empty($login)) $error .= '<li>Не указан логин</li>';
    if(empty($pass)) $error .= '<li>Не указан пароль</li>';
    if(empty($name)) $error .= '<li>Не указано имя</li>';
    if(empty($email)) $error .= '<li>Не указан Email</li>';
    
    if(empty($error)){
        // если все поля заполнены
        // проверяем нет ли такого юзера в БД
        $query = "SELECT customer_id FROM customers WHERE login = '" .clear($login). "' LIMIT 1";
        $res = mysql_query($query) or die(mysql_error());
        $row = mysql_num_rows($res); // 1 - такой юзер есть, 0 - нет
        if($row){
            // если такой логин уже есть
			$_SESSION['reg']['res'] = "<div class='panel panel-danger'>";
			$_SESSION['reg']['res'] .= "<div class='panel-heading'>Нелопустимое имя пользователя</div>";
			$_SESSION['reg']['res'] .= "<div class='panel-body'>Пользователь с таким логином уже зарегистрирован на сайте. Введите другой логин.</div>";
			$_SESSION['reg']['res'] .= "</div>";
            $_SESSION['reg']['name'] = $name;
            $_SESSION['reg']['email'] = $email;
            $_SESSION['reg']['phone'] = $phone;
            $_SESSION['reg']['address'] = $address;
        }else{
            // если все ок - регистрируем
			// Проверка на уникальность почтового ящика
			$query = "SELECT email FROM customers WHERE email = '" .$email. "' LIMIT 1";
			$res = mysql_query($query) or die(mysql_error());
			if(mysql_affected_rows() > 0){
				$_SESSION['reg']['res'] = "<div class='panel panel-danger'>";
				$_SESSION['reg']['res'] .= "<div class='panel-heading'>Ошибка</div>";
				$_SESSION['reg']['res'] .= "<div class='panel-body'>Пользователь с таким email уже есть в системе.</div>";
				$_SESSION['reg']['res'] .= "</div>";
				$_SESSION['reg']['login'] = $login;
				$_SESSION['reg']['name'] = $name;
				$_SESSION['reg']['email'] = $email;
				$_SESSION['reg']['phone'] = $phone;
				$_SESSION['reg']['address'] = $address;
				return;
			}
			//Создаем папку для пользователя, куда будем склабывать все картинки
			$m_path=generateString();
			$folder = USERFILES . $m_path . '/' . USERFILES_PRODUCTIMG;
			if (createFolder($folder)==0){
				$login = clear($login);
				$name = clear($name);
				$email = clear($email);
				$phone = clear($phone);
				$address = clear($address);
				$pass = md5($pass);

				$query = "INSERT INTO customers (name, email, phone, address, login, password, path_files, img)
							VALUES ('$name', '$email', '$phone', '$address', '$login', '$pass','$m_path','views/wood/images/user.png')";
				$res = mysql_query($query) or die(mysql_error());
				if(mysql_affected_rows() > 0){
					// если запись добавлена
					$_SESSION['reg']['res'] = "<div class='panel panel-success'>";
					$_SESSION['reg']['res'] .= "<div class='panel-heading'>Регистрация успешна.</div>";
					$_SESSION['reg']['res'] .= "<div class='panel-body'>Регистрация прошла успешно.</div>";
					$_SESSION['reg']['res'] .= "</div>";
					$_SESSION['auth']['user'] = $_POST['name'];
					$_SESSION['auth']['customer_id'] = mysql_insert_id();
					$_SESSION['auth']['email'] = $email;
					$_SESSION['auth']['path'] = $m_path;
				}else{
					$_SESSION['reg']['res'] = "<div class='panel panel-danger'>";
					$_SESSION['reg']['res'] .= "<div class='panel-heading'>Ошибка</div>";
					$_SESSION['reg']['res'] .= "<div class='panel-body'>Не добавлена запись в таблицу пользователей.</div>";
					$_SESSION['reg']['res'] .= "</div>";
					$_SESSION['reg']['login'] = $login;
					$_SESSION['reg']['name'] = $name;
					$_SESSION['reg']['email'] = $email;
					$_SESSION['reg']['phone'] = $phone;
					$_SESSION['reg']['address'] = $address;
				}
			}else{
				$_SESSION['reg']['res'] = "<div class='panel panel-danger'>";
				$_SESSION['reg']['res'] .= "<div class='panel-heading'>Ошибка</div>";
				$_SESSION['reg']['res'] .= "<div class='panel-body'>Не создана папка на сервере.</div>";
				$_SESSION['reg']['res'] .= "</div>";
				$_SESSION['reg']['login'] = $login;
				$_SESSION['reg']['name'] = $name;
				$_SESSION['reg']['email'] = $email;
				$_SESSION['reg']['phone'] = $phone;
				$_SESSION['reg']['address'] = $address;				
			}
        }
    }else{
        // если не заполнены обязательные поля
		$_SESSION['reg']['res'] = "<div class='panel panel-danger'>";
		$_SESSION['reg']['res'] .= "<div class='panel-heading'>Не заполнены обязательные поля</div>";
		$_SESSION['reg']['res'] .= "<div class='panel-body'><ul> $error </ul></div>";
		$_SESSION['reg']['res'] .= "</div>";
        $_SESSION['reg']['login'] = $login;
        $_SESSION['reg']['name'] = $name;
        $_SESSION['reg']['email'] = $email;
        $_SESSION['reg']['phone'] = $phone;
        $_SESSION['reg']['address'] = $address;
    }
}
/* ===Регистрация=== */

/* ===Авторизация=== */
function authorization(){
    $login = mysql_real_escape_string(trim($_POST['login_auth']));
    $pass = trim($_POST['pass']);
    if(empty($login) OR empty($pass)){
        // если пусты поля логин/пароль
        $_SESSION['auth']['error'] = "Поля логин/пароль должны быть заполнены!";
    }else{
        // если получены данные из полей логин/пароль
        $pass = md5($pass);
        
        $query = "SELECT customer_id, name, email, path_files FROM customers WHERE login = '$login' AND password = '$pass' LIMIT 1";
        $res = mysql_query($query) or die(mysql_error());
        if(mysql_num_rows($res) == 1){
            // если авторизация успешна
            $row = mysql_fetch_row($res);
            $_SESSION['auth']['customer_id'] = $row[0];
            $_SESSION['auth']['user'] = $row[1];
            $_SESSION['auth']['email'] = $row[2];
			$_SESSION['auth']['path'] = $row[3];
			//Получаем информацию по магазину
			//Пока считаем, что он только один.
			$sites = get_sites($_SESSION['auth']['customer_id']);
			If (count($sites)>0) {
				$_SESSION['auth']['site_id'] = $sites[0]['site_id'];
			} 
        }else{
            // если неверен логин/пароль
            $_SESSION['auth']['error'] = "Логин/пароль введены неверно!";
        }
    }
}
/* ===Авторизация=== */

/* ===Способы доставки=== */
function get_dostavka(){
    $query = "SELECT * FROM dostavka";
    $res = mysql_query($query);
    
    $dostavka = array();
    while($row = mysql_fetch_assoc($res)){
        $dostavka[] = $row;
    }
    
    return $dostavka;
}
/* ===Способы доставки=== */

/* ===Добавление заказа=== */
function add_order(){
    // получаем общие данные для всех (авторизованные и не очень)
    $dostavka_id = (int)$_POST['dostavka'];
    if(!$dostavka_id) $dostavka_id = 1;
    $prim = trim($_POST['prim']);
    if($_SESSION['auth']['user']) $customer_id = $_SESSION['auth']['customer_id'];
    
    if(!$_SESSION['auth']['user']){
        $error = ''; // флаг проверки пустых полей
    
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $address = trim($_POST['address']);
        
        if(empty($name)) $error .= '<li>Не указано ФИО</li>';
        if(empty($email)) $error .= '<li>Не указан Email</li>';
        if(empty($phone)) $error .= '<li>Не указан телефон</li>';
        if(empty($address)) $error .= '<li>Не указан адрес</li>';
        
        if(empty($error)){
            // добавляем гостя в заказчики (но без данных авторизации)
            $customer_id = add_customer($name, $email, $phone, $address);
            if(!$customer_id) return false; // прекращаем выполнение в случае возникновения ошибки добавления гостя-заказчика
        }else{
            // если не заполнены обязательные поля
            $_SESSION['order']['res'] = "<div class='error'>Не заполнены обязательные поля: <ul> $error </ul></div>";
            $_SESSION['order']['name'] = $name;
            $_SESSION['order']['email'] = $email;
            $_SESSION['order']['phone'] = $phone;
            $_SESSION['order']['addres'] = $address;
            $_SESSION['order']['prim'] = $prim;
            return false;
        }
    }
    $_SESSION['order']['email'] = $email;
    save_order($customer_id, $dostavka_id, $prim);
}
/* ===Добавление заказа=== */

/* ===Добавление заказчика-гостя=== */
function add_customer($name, $email, $phone, $address){
    $name = clear($_POST['name']);
    $email = clear($_POST['email']);
    $phone = clear($_POST['phone']);
    $address = clear($_POST['address']);
    $query = "INSERT INTO customers (name, email, phone, address)
                VALUES ('$name', '$email', '$phone', '$address')";
    $res = mysql_query($query);
    if(mysql_affected_rows() > 0){
        // если гость добавлен в заказчики - получаем его ID
        return mysql_insert_id();
    }else{
        // если произошла ошибка при добавлении
        $_SESSION['order']['res'] = "<div class='error'>Произошла ошибка при регистрации заказа</div>";
        $_SESSION['order']['name'] = $name;
        $_SESSION['order']['email'] = $email;
        $_SESSION['order']['phone'] = $phone;
        $_SESSION['order']['addres'] = $address;
        $_SESSION['order']['prim'] = $address;
        return false;
    }
}
/* ===Добавление заказчика-гостя=== */

/* ===Сохранение заказа=== */
function save_order($customer_id, $dostavka_id, $prim){
    $prim = clear($prim);
    $query = "INSERT INTO orders (`customer_id`, `date`, `dostavka_id`, `prim`)
                VALUES ($customer_id, NOW(), $dostavka_id, '$prim')";
    mysql_query($query) or die(mysql_error());
    if(mysql_affected_rows() == -1){
        // если не получилось сохранить заказ - удаляем заказчика
        mysql_query("DELETE FROM customers
                        WHERE customer_id = $customer_id AND login = ''");
        return false;
    }
    $order_id = mysql_insert_id(); // ID сохраненного заказа
    
    foreach($_SESSION['cart'] as $goods_id => $value){
        $val .= "($order_id, $goods_id, {$value['qty']}, '{$value['name']}', {$value['price']}),";    
    }
    $val = substr($val, 0, -1); // удаляем последнюю запятую
    
    $query = "INSERT INTO zakaz_tovar (orders_id, goods_id, quantity, name, price)
                VALUES $val";
    mysql_query($query) or die(mysql_error());
    if(mysql_affected_rows() == -1){
        // если не выгрузился заказа - удаляем заказчика (customers) и заказ (orders)
        mysql_query("DELETE FROM orders WHERE order_id = $order_id");
        mysql_query("DELETE FROM customers
                        WHERE customer_id = $customer_id AND login = ''");
        return false;
    }
    
    if($_SESSION['auth']['email']) $email = $_SESSION['auth']['email'];
        else $email = $_SESSION['order']['email'];
    mail_order($order_id, $email);
    
    // если заказ выгрузился
    unset($_SESSION['cart']);
    unset($_SESSION['total_sum']);
    unset($_SESSION['total_quantity']);
    $_SESSION['order']['res'] = "<div class='success'>Спасибо за Ваш заказ. В ближайшее время с Вами свяжется менеджер для согласования заказа.</div>";
    return true;
}
/* ===Сохранение заказа=== */

/* ===Отправка уведомлений о заказе на email=== */
function mail_order($order_id, $email){
    //mail(to, subject, body, header);
    // тема письма
    $subject = "Заказ в интернет-магазине";
    // заголовки
    $headers .= "Content-type: text/plain; charset=utf-8\r\n";
    $headers .= "From: WoodHand";
    // тело письма
    $mail_body = "Благодарим Вас за заказ!\r\nНомер Вашего заказа - {$order_id}
    \r\n\r\nЗаказанные товары:\r\n";
    // атрибуты товара
    foreach($_SESSION['cart'] as $goods_id => $value){
        $mail_body .= "Наименование: {$value['name']}, Цена: {$value['price']}, Количество: {$value['qty']} шт.\r\n";
    }
    $mail_body .= "\r\nИтого: {$_SESSION['total_quantity']} на сумму: {$_SESSION['total_sum']}";
    
    // отправка писем
    mail($email, $subject, $mail_body, $headers);
    mail(ADMIN_EMAIL, $subject, $mail_body, $headers);
}
/* ===Отправка уведомлений о заказе на email=== */

/* ===Поиск=== */
function search(){
    $search = clear($_GET['search']);
    $result_search = array(); //результат поиска
    
    if(mb_strlen($search, 'UTF-8') < 4){
        $result_search['notfound'] = "<div class='error'>Поисковый запрос должен содержать не менее 4-х символов</div>";
    }else{
        $query = "SELECT goods_id, name, img, price, hits, new, sale
                    FROM goods
                        WHERE MATCH(name) AGAINST('{$search}*' IN BOOLEAN MODE) AND visible='1'";
        $res = mysql_query($query) or die(mysql_error());
        
        if(mysql_num_rows($res) > 0){
            while($row_search = mysql_fetch_assoc($res)){
                $result_search[] = $row_search;
            }
        }else{
            $result_search['notfound'] = "<div class='error'>По Вашему запросу ничего не найдено</div>";
        }
    }
    
    return $result_search;
}
/* ===Поиск=== */

/* ===Отдельный товар=== */
function get_goods($goods_id){
    $query = "SELECT * FROM goods WHERE goods_id = $goods_id AND visible = '1'";
    $res = mysql_query($query);
    
    $goods = array();
    $goods = mysql_fetch_assoc($res);
    if($goods['img_slide']){
        $goods['img_slide'] = explode("|", $goods['img_slide']);
    }
    
    return $goods;
}
/* ===Отдельный товар=== */

/* === Галерея === */
function get_galery($galery_id){
    $query = "SELECT * FROM galerys WHERE galery_id = $galery_id";
    $res = mysql_query($query);
    
    $items = array();
    $items = mysql_fetch_assoc($res);
    return $items;
}
/* === Галерея === */
/* === Получение файлов галереи === */
function get_galery_files($galery_id){
    $query = "SELECT * FROM files WHERE galery_id = $galery_id";
    $res = mysql_query($query);
    
    $items = array();
    while($row = mysql_fetch_assoc($res)){
        $items[] = $row;
    }
    return $items;
}
/* === Получение файлов галереи === */

/* ===Отправка письма=== */
function send_mail(){
    $error = ''; // флаг проверки пустых полей
    
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);
    
    if(empty($name)) $error = '<li>Не указано имя</li>';
    if(empty($email)) $error .= '<li>Не указан Email</li>';
    if(empty($message)) $error .= '<li>Не введено сообщение</li>';
    
    if(empty($error)){
		$captcha=chek_captcha();
		if ($captcha != null && $captcha->success) {
			s_mail($email, $name, $message);			
			return true;
		}else {
			$_SESSION['mess']['res'] = "<div class='error'>Здравствуйте " . $_POST["name"] . " (" . $_POST["email"] . "), Ошибка проверки капчи.</div>";
			$_SESSION['mess']['name'] = $name;
			$_SESSION['mess']['email'] = $email;
			$_SESSION['mess']['message'] = $message;
			return false;
		}
	}else{
        // если не заполнены обязательные поля
        $_SESSION['mess']['res'] = "<div class='error'>Не заполнены обязательные поля: <ul> $error </ul></div>";
        $_SESSION['mess']['name'] = $name;
        $_SESSION['mess']['email'] = $email;
        $_SESSION['mess']['message'] = $message;
    }
}
/* ===Отправка письма=== */

/* ===Проверка капчи=== */
function chek_captcha(){

	// пустой ответ
	$response = null;
	 
	// проверка секретного ключа
	$reCaptcha = new ReCaptcha(PRIVATEKEY);

	// if submitted check response
	if ($_POST["g-recaptcha-response"]) {
		$response = $reCaptcha->verifyResponse(
			$_SERVER["REMOTE_ADDR"],
			$_POST["g-recaptcha-response"]
		);
	}

	
/*
		if ($response != null && $response->success) { 
			$_SESSION['mess']['res'] = "<div class='success'>Здравствуйте " . $_POST["name"] . " (" . $_POST["email"] . "), Ваше письмо успешно отправлено.</div>";
		} else {
			$_SESSION['mess']['res'] = "<div class='error'>Здравствуйте " . $_POST["name"] . " (" . $_POST["email"] . "), Ошибка оправления письма.</div>";
		
		}

*/		
	return $response;
}
/* ===Проверка капчи=== */

/* ===Настройка управления магазином=== */
/* === Получение кол-ва магазинов, сайтов=== */
function get_sites($customer_id){
    $query = "SELECT * FROM sites WHERE customer_id = $customer_id";
    $res = mysql_query($query);
    
    $items = array();
    while($row = mysql_fetch_assoc($res)){
        $items[] = $row;
    }
    return $items;
}
/* === Получение кол-ва магазинов, сайтов=== */
/* === Получение информации по магазину, сайту=== */
function get_site($site_id){
    $query = "SELECT * FROM sites WHERE site_id = $site_id";
    $res = mysql_query($query);
    
    $items = array();
	$items = mysql_fetch_assoc($res);
		
	return $items;
}
/* === Получение информации по магазину, сайту=== */
/* === Получение валют=== */
function get_valuta(){
    $query = "SELECT * FROM valuta";
    $res = mysql_query($query);
    
    $items = array();
    while($row = mysql_fetch_assoc($res)){
        $items[] = $row;
    }
    return $items;
}
/* === Получение валют=== */
/* ===Добавление сайта, магазина === */
function add_site(){
    $error = ''; // флаг проверки пустых полей
    
    $site_nam = trim($_POST['site_nam']);
    $site_title = trim($_POST['site_title']);
    $site_rem = trim($_POST['site_rem']);
    $val_id = trim($_POST['val_id']);
    $customer_id = $_SESSION['auth']['customer_id'];
    
    if(empty($site_nam)) $error .= '<li>Не указано английское название сайта</li>';
    if(empty($site_title)) $error .= '<li>Не указан заголовок сайта</li>';
    if(empty($site_rem)) $error .= '<li>Не указан комментарий сайта</li>';
    if(empty($val_id)) $error .= '<li>Не введена валюта</li>';
    
    if(empty($error)){
        // если все поля заполнены
        // проверяем нет ли такого магазина, сайта в БД
		$query = "SELECT site_id FROM sites WHERE site_nam = '" .clear($site_nam). "' LIMIT 1";
        $res = mysql_query($query) or die(mysql_error());
        $row = mysql_num_rows($res); // 1 - такой сайт есть, 0 - нет
        if($row){
            // если такой логин уже есть
			$_SESSION['info']['res'] = "<div class='panel panel-danger'>";
			$_SESSION['info']['res'] .= "<div class='panel-heading'>Нелопустимое имя магазина</div>";
			$_SESSION['info']['res'] .= "<div class='panel-body'>Магазин с таким именем уже зарегистрирован на сайте. Введите другое английское имя.</div>";
			$_SESSION['info']['res'] .= "</div>";
            $_SESSION['info']['site_nam'] = $site_nam;
            $_SESSION['info']['site_title'] = $site_title;
            $_SESSION['info']['site_rem'] = $site_rem;
            $_SESSION['info']['val_id'] = $val_id;
        }else{
            // если все ок - регистрируем
            $site_nam = clear($site_nam);
            $site_title = clear($site_title);
            $site_rem = clear($site_rem);
            $val_id = clear($val_id);
			
			$query = "INSERT INTO sites (site_nam, site_title, site_rem, val_id, customer_id)
						VALUES ('$site_nam', '$site_title', '$site_rem', $val_id, $customer_id)";
			$res = mysql_query($query);
			if(mysql_affected_rows() > 0){
				// если запись добавлена
				$_SESSION['info']['res'] = "<div class='panel panel-success'>";
				$_SESSION['info']['res'] .= "<div class='panel-heading'>Магазин.</div>";
				$_SESSION['info']['res'] .= "<div class='panel-body'>Магазин создан успешно.</div>";
				$_SESSION['info']['res'] .= "</div>";
				//Создаем сессионную переменную с идом магазина.
				$_SESSION['auth']['site_id'] = mysql_insert_id();
			}else{
				$_SESSION['info']['res'] = "<div class='panel panel-danger'>";
				$_SESSION['info']['res'] .= "<div class='panel-heading'>Ошибка</div>";
				$_SESSION['info']['res'] .= "<div class='panel-body'>Не добавлена запись в таблицу магазинов.<br />".mysql_error()."</div>";
				$_SESSION['info']['res'] .= "</div>";
				$_SESSION['info']['site_nam'] = $site_nam;
				$_SESSION['info']['site_title'] = $site_title;
				$_SESSION['info']['site_rem'] = $site_rem;
				$_SESSION['info']['val_id'] = $val_id;
			}
		}
    }else{
        // если не заполнены обязательные поля
		$_SESSION['info']['res'] = "<div class='panel panel-danger'>";
		$_SESSION['info']['res'] .= "<div class='panel-heading'>Не заполнены обязательные поля</div>";
		$_SESSION['info']['res'] .= "<div class='panel-body'><ul> $error </ul></div>";
		$_SESSION['info']['res'] .= "</div>";
		$_SESSION['info']['site_nam'] = $site_nam;
		$_SESSION['info']['site_title'] = $site_title;
		$_SESSION['info']['site_rem'] = $site_rem;
		$_SESSION['info']['val_id'] = $val_id;
    }
}
/* ===Добавление сайта=== */
/* ===Добавление сайта, магазина === */
function edit_site($site_id){
    $error = ''; // флаг проверки пустых полей
    
    $site_title = trim($_POST['site_title']);
    $site_rem = trim($_POST['site_rem']);

    if(empty($site_title)) $error .= '<li>Не указан заголовок сайта</li>';
    if(empty($site_rem)) $error .= '<li>Не указан комментарий сайта</li>';
    
    if(empty($error)){
        // если все поля заполнены

            // если все ок - регистрируем
            $site_title = clear($site_title);
            $site_rem = clear($site_rem);

            $query = "UPDATE sites  SET site_title = '$site_title', site_rem = '$site_rem'
                        WHERE site_id = $site_id";
            $res = mysql_query($query);
            if(mysql_affected_rows() > 0){
                // если запись добавлена
				$_SESSION['info']['res'] = "<div class='panel panel-success'>";
				$_SESSION['info']['res'] .= "<div class='panel-heading'>Сохранение.</div>";
				$_SESSION['info']['res'] .= "<div class='panel-body'>Сохранение прошло успешно.</div>";
				$_SESSION['info']['res'] .= "</div>";
            }else{
				$_SESSION['info']['res'] = "<div class='panel panel-danger'>";
				$_SESSION['info']['res'] .= "<div class='panel-heading'>Ошибка</div>";
				$_SESSION['info']['res'] .= "<div class='panel-body'>Данные не изменены.<br />".mysql_error()."</div>";
				$_SESSION['info']['res'] .= "</div>";
				$_SESSION['info']['site_title'] = $site_title;
				$_SESSION['info']['site_rem'] = $site_rem;
            }
    }else{
        // если не заполнены обязательные поля
		$_SESSION['info']['res'] = "<div class='panel panel-danger'>";
		$_SESSION['info']['res'] .= "<div class='panel-heading'>Не заполнены обязательные поля</div>";
		$_SESSION['info']['res'] .= "<div class='panel-body'><ul> $error </ul></div>";
		$_SESSION['info']['res'] .= "</div>";
		$_SESSION['info']['site_title'] = $site_title;
		$_SESSION['info']['site_rem'] = $site_rem;
    }
}
/* ===Добавление сайта=== */

/* ===Работа с пользователями=== */
	/* ---Получение списка пользователей---	*/
	function get_users($start_pos, $perpage){
		$query = "SELECT customer_id, name, login, email, name_role
					FROM customers
					LEFT JOIN roles
						ON customers.id_role = roles.id_role
					WHERE login IS NOT NULL LIMIT $start_pos, $perpage";
		$res = mysql_query($query);
		$items = array();
		while($row = mysql_fetch_assoc($res)){
			$items[] = $row;
		}
		return $items;
	}
	/* ---Получение списка пользователей---	*/
	/* ---Получение пользователя---	*/
	function get_user($customer_id){
		$query = "SELECT customers.*, name_role
					FROM customers
					LEFT JOIN roles
						ON customers.id_role = roles.id_role
					WHERE customer_id = $customer_id LIMIT 1";
		$res = mysql_query($query);
		$items = array();
		$items = mysql_fetch_assoc($res);
		
		return $items;
	}
	/* ---Получение пользователя---	*/
/* ---Редактирование пользователя ---	*/
function prof_save($customer_id, $path_files) {
    $error = ''; // флаг проверки пустых полей

    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    
    if(empty($name)) $error .= '<li>Не указано ФИО</li>';

    if(empty($error)){
        
		$name = clear($name);
        $phone = clear($phone);
        $address = clear($address);

        
        $query = "UPDATE customers SET name = '$name', phone = '$phone', address = '$address' 
                    WHERE customer_id = $customer_id";      
	
        $res = mysql_query($query) or die(mysql_error());
        
		
/*         if(mysql_affected_rows() > 0){


        }else{
            $_SESSION['answer'] = "<div class='error'>Ошибка при сохранении профиля пользователя.<br/>".$query."</div>";

        }
 */		            $types = array("image/gif", "image/png", "image/jpeg", "image/pjpeg", "image/x-png"); // массив допустимых расширений
            /* базовая картинка */
            if($_FILES['baseimg']['name']){
				
                $baseimgExt = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $_FILES['baseimg']['name'])); // расширение картинки
                $baseimgName = $_SESSION['auth']['user'].".".$baseimgExt; // новое имя картинки
                $baseimgTmpName = $_FILES['baseimg']['tmp_name']; // временное имя файла
                $baseimgSize = $_FILES['baseimg']['size']; // вес файла
                $baseimgType = $_FILES['baseimg']['type']; // тип файла
                $baseimgError = $_FILES['baseimg']['error']; // 0 - OK, иначе - ошибка
                $error = "";
                
                if(!in_array($baseimgType, $types)) $error .= "Допустимые расширения - .gif, .jpg, .png <br />";
                if($baseimgSize > SIZE) $error .= "Максимальный вес файла - 1 Мб";
                if($baseimgError) $error .= "Ошибка при загрузке файла. Возможно, файл слишком большой";
                
                if(!empty($error)) $_SESSION['answer'] = "<div class='error'>Ошибка при загрузке картинки товара! <br /> {$error}</div>";
                
                // если нет ошибок
                if(empty($error)){
					$folder = USERFILES . $path_files . '/';
					$folder_tmp = USERFILES . 'tmp/';
                    if(@move_uploaded_file($baseimgTmpName, $folder_tmp.$baseimgName)){
                        resize($folder_tmp.$baseimgName, $folder.$baseimgName, 120, 185, $baseimgExt);
                        //@unlink("../userfiles/product_img/tmp/$baseimgName");
                        mysql_query("UPDATE customers SET img = '".$folder.$baseimgName."' WHERE customer_id = $customer_id");
                    }else{
                        $_SESSION['answer'] .= "<div class='error'>Не удалось переместить загруженную картинку. Проверьте права на папки в каталоге /userfiles/product_img/</div>";
                    }
                }
            }
            /* базовая картинка */
            ///////////////////////// 
            $_SESSION['answer'] .= "<div class='success'>Сохранено.</div>";
		}else {
			$_SESSION['answer'] .= $error;
		}
	}
	/* ---Редактирование пользователя ---	*/
/* ===Работа с пользователями=== */

/* ===Добавление товара=== */
function add_product(){
    $name = trim($_POST['name']);
    $price = round(floatval(preg_replace("#,#", ".", $_POST['price'])),2);
    $keywords = trim($_POST['keywords']);
    $description = trim($_POST['description']);
    $goods_catid = (int)$_POST['goods_catid'];
    $anons = trim($_POST['anons']);
    $content = trim($_POST['content']);
    $new = (int)$_POST['new'];
    $hits = (int)$_POST['hits'];
    $sale = (int)$_POST['sale'];
    $visible = (int)$_POST['visible'];
    $date = date("Y-m-d");
    
    if(empty($name)){
        $_SESSION['add_product']['res'] = "<div class='error'>У товара должно быть название</div>";
        $_SESSION['add_product']['price'] = $price;
        $_SESSION['add_product']['keywords'] = $keywords;
        $_SESSION['add_product']['description'] = $description;
        $_SESSION['add_product']['anons'] = $anons;
        $_SESSION['add_product']['content'] = $content;
        return false;
    }else{
        $name = clear($name);
        $keywords = clear($keywords);
        $description = clear($description);
        $anons = clear($anons);
        $content = clear($content);
        
        $query = "INSERT INTO goods (name, site_id, keywords, description, goods_catid, anons, content, hits, new, sale, price, date, visible)
                    VALUES ('$name', {$_SESSION['auth']['site_id']}, '$keywords', '$description', $goods_catid, '$anons', '$content', '$hits', '$new', '$sale', $price, '$date', '$visible')";        
        $res = mysql_query($query) or die(mysql_error());
        
        if(mysql_affected_rows() > 0){
            $id = mysql_insert_id(); // ID сохраненного товара
			// если запись добавлена
			$res_return = array("answer" => "OK", "goods_id" => $id);
		}else{
			$res_return = array("answer" => "SQL error in module add_product.\n\r SqlError - ".mysql_error(), "query" => $query);
		}
        echo json_encode($res_return);
    }
}
/* ===Добавление товара=== */

/* ===Редактирование товара=== */
function edit_product($id){
    $name = trim($_POST['name']);
    $price = round(floatval(preg_replace("#,#", ".", $_POST['price'])),2);
    $keywords = trim($_POST['keywords']);
    $description = trim($_POST['description']);
    $goods_catid = (int)$_POST['goods_catid'];
    $anons = trim($_POST['anons']);
    $content = trim($_POST['content']);
    $new = (int)$_POST['m_new'];
    $hits = (int)$_POST['hits'];
    $sale = (int)$_POST['sale'];
    $visible = (int)$_POST['visible'];
    
    if(empty($name)){
        $_SESSION['edit_product']['res'] = "<div class='error'>У товара должно быть название</div>";
        return false;
    }else{
        $name = clear_admin($name);
        $keywords = clear_admin($keywords);
        $description = clear_admin($description);
        $anons = clear_admin($anons);
        $content = clear_admin($content);
        
        $query = "UPDATE goods SET
                    name = '$name',
                    keywords = '$keywords',
                    description = '$description',
                    goods_catid = $goods_catid,
                    anons = '$anons',
                    content = '$content',
                    hits = '$hits',
                    new = '$new',
                    sale = '$sale',
                    price = $price,
                    visible = '$visible'
                        WHERE goods_id = $id";
        $res = mysql_query($query);
		if(mysql_affected_rows() > 0 or (!mysql_error())){
			// если запись добавлена
			$res_return = array("answer" => "OK");
		}else{
			$res_return = array("answer" => "SQL error in module edit_product.\n\r SqlError - ".mysql_error(), "query" => $query);
		}
        echo json_encode($res_return);
    }

}
/* ===Редактирование товара=== */
/* ===Удалене товара=== */
function del_product($id){
	$query = "SELECT * FROM goods_pic WHERE goods_id = $id";

   $res = mysql_query($query);
	if(mysql_affected_rows() > 0 or (!mysql_error())){
		$items = array();
		while($row = mysql_fetch_assoc($res)){
			if (!goods_pic_del($row['pic_id'], False)) {
				$res_return = array('answer' => $_SESSION['info']['res']);
				echo json_encode($res_return);	
				return;
			}
			
		}
		//Удалям запись из базы.
		$query = " DELETE FROM goods WHERE goods_id = $id";
		$res = mysql_query($query);
		if(mysql_affected_rows() > 0 or (!mysql_error())){
			// если запись удалена
			$res_return = array('answer' => 'OK');
		}else{
			$res_return = array('answer' => 'SQL error in module del_product.\n\r SqlError - '.mysql_error(), 'query' => $query);
		}
	}else{
		$res_return = array('answer' => 'SQL error in module del_product.\n\r SqlError - '.mysql_error(), 'query' => $query);
	}
	echo json_encode($res_return);	
}
/* ===Удаление товара=== */
/* ===Получение данных товара=== */
function get_product($goods_id){
    $query = "SELECT goods.*, category.parent_id, path, 
				IFNULL((SELECT CONCAT(pic_path,'m_',pic_name) FROM goods_pic where goods_id = goods.goods_id and glav='1' ),'".TEMPLATE."images/noimg.png') as pic
				FROM goods
				LEFT JOIN category ON goods.goods_catid = category.cat_id 
				INNER JOIN sites ON goods.site_id = sites.site_id
				WHERE goods_id = $goods_id";
    $res = mysql_query($query);
    
    $product = array();
    $product = mysql_fetch_assoc($res);
    return $product;
}
/* ===Получение данных товара=== */
/* ===Получение изображений к товару=== */
function get_goods_pic($goods_id){
    $query = "SELECT * FROM goods_pic WHERE goods_id = $goods_id";
    $res = mysql_query($query);
    
    $items = array();
    while($row = mysql_fetch_assoc($res)){
        $items[] = $row;
    }
    return $items;
}
/* ===Получение изображений к товару=== */

/* ===Получение изображения по pic_id=== */
function goods_pic_get_by_id($pic_id){
    $query = "SELECT * FROM goods_pic WHERE pic_id = $pic_id";
    $res = mysql_query($query);
    
    $items = array();
    $items = mysql_fetch_assoc($res);
    return $items;
}
/* ===Получение изображений к товару=== */

/* ===Добавление изображений к товару=== */
function goods_pic_add(){
    $goods_id = (int)$_POST['goods_id'];
    $pic_path_tmp = str_replace(PATH, "", clear_admin(trim($_POST['pic_path'])));
	$path_parts = pathinfo($pic_path_tmp);
	$pic_path_tmp = $path_parts['dirname'].'/';
    $pic_name =  substr($path_parts['basename'],2);
    $name = clear_admin(trim($_POST['name']));
	$glav = (int)$_POST['glav'];
 	$x1 = (int)$_POST['x1'];
 	$y1 = (int)$_POST['y1'];
 	$x2 = (int)$_POST['x2'];
 	$y2 = (int)$_POST['y2'];
	$pic_path = USERFILES.$_SESSION['auth']['path'].PRODUCTIMG;
   
	$query = "INSERT INTO goods_pic (pic_path, pic_name, goods_id, x1, y1, x2, y2, name, glav)
				VALUES ('$pic_path', '$pic_name', $goods_id, $x1, $y1, $x2, $y2, '$name', '$glav')";
	$res = mysql_query($query);
	if(mysql_affected_rows() > 0 or (!mysql_error())){
		//Перемещаем большую картинку
		$tempFile = USERFILES.'tmp/' . $pic_name;
		$targetFile = $pic_path.$pic_name;
		rename($tempFile,$targetFile);
		//Перемещаем среднюю картинку
		$tempFile = USERFILES.'tmp/'.$path_parts['basename'];
		$targetFile = $pic_path.$path_parts['basename'];
		rename($tempFile,$targetFile);
		//Создаем третью картинку, размером 140х140
		$image_location = $pic_path;
		$thumb_image_location = $image_location . 't_'. $pic_name;
		$large_image_location = $image_location . 'm_'. $pic_name;
		if (file_exists($thumb_image_location)) {
			unlink($thumb_image_location);
		}
		$scale = 140/($y2-$y1);
		$cropped = resizeThumbnailImage($thumb_image_location, $large_image_location,$y2-$y1,$x2-$x1,$x1,$y1,$scale);

		$res_return = array('answer' => 'OK');
	}else{
		$res_return = array('answer' => 'SQL error in module add_product.\n\r SqlError - '.mysql_error(), 'query' => $query);
	}

	echo json_encode($res_return);	
	
	
}

/* ===Добавление изображений к товару=== */
/* ===Редактирование изображений к товару=== */
//При редактировании сам файл не меняем, и не меняем goods_id. 
//Если необходимо изменить файл, удаляем запись, и добавляем новую.
function goods_pic_edit($pic_id){
    $name = clear_admin(trim($_POST['name']));
 	$x1 = (int)$_POST['x1'];
 	$y1 = (int)$_POST['y1'];
 	$x2 = (int)$_POST['x2'];
 	$y2 = (int)$_POST['y2'];
	$glav = (int)$_POST['glav'];
   
	//Получение предидущих данных
	$goods_pic = goods_pic_get_by_id($pic_id);
	

	
	if ($goods_pic['x1']<>$x1 OR $goods_pic['x2']<>$x2 OR $goods_pic['y1']<>$y1 OR $goods_pic['y2']<>$y2) {
		//Если координаты вделенной области изменились, то перегенерим изображение размером 140х140
		//Сначала обрезаем изображение по новым точкам, затем ресайзим
		$pic_name = $goods_pic['pic_name'];
		$image_location = $goods_pic['pic_path'];
		$thumb_image_location = $image_location . 't_'. $pic_name;
		$large_image_location = $image_location . 'm_'. $pic_name;
		if (file_exists($thumb_image_location)) {
			unlink($thumb_image_location);
		}
		$scale = 140/($y2-$y1);

		$cropped = resizeThumbnailImage($thumb_image_location, $large_image_location,$y2-$y1,$x2-$x1,$x1,$y1,$scale);
	}

	$query = "UPDATE goods_pic SET x1 = $x1, y1 = $y1, x2 = $x2, y2 = $y2, name = '$name', glav = '$glav'
				WHERE pic_id = $pic_id";
	$res = mysql_query($query);
	if(mysql_affected_rows() > 0 or (!mysql_error())){
		// если запись удалена
		$res_return = array('answer' => 'OK');
	}else{
		$res_return = array('answer' => 'SQL error in module edit_product.\n\r SqlError - '.mysql_error(), 'query' => $query);
	}

	echo json_encode($res_return);	
}

/* ===Удаление изображений к товару=== */
function goods_pic_del($pic_id, $return_json=True){
    //Получаем имя файла по его id
	$query = "SELECT * FROM goods_pic WHERE pic_id = $pic_id";


	$b_res = True;
    $res = mysql_query($query);
	if(mysql_affected_rows() > 0 or (!mysql_error())){
		$item = array();
		$item = mysql_fetch_assoc($res);
		//Удалям маленькую и большую картинку, с подавлением ошибок.
		@unlink($item['pic_path'].$item['pic_name']);
		@unlink($item['pic_path'].'m_'.$item['pic_name']);
		@unlink($item['pic_path'].'t_'.$item['pic_name']);
		//Удалям запись из базы.
		$query = " DELETE FROM goods_pic WHERE pic_id = $pic_id";
		$res = mysql_query($query);
		if(mysql_affected_rows() > 0 or (!mysql_error())){
			// если запись удалена
			$res_return = array('answer' => 'OK');
		}else{
			$b_res = False;
			$_SESSION['info']['res'] = $query;
		}
	}else{
		$b_res=False;
		$res_return = array('answer' => 'SQL error in module goods_pic_del.\n\r SqlError - '.mysql_error(), 'query' => $query);
	}
	if ($return_json) {
		echo json_encode($res_return);
	}else {
		return $b_res;
	}
}

/* ===Удаление изображений к товару=== */