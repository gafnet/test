<?php 
define('ISHOP', TRUE);
include_once '../../config.php';

    $query = "SELECT galery_id, galery_nam, position FROM galerys ORDER BY position";
    $res = mysql_query($query);
	if(mysql_affected_rows() > 0){
		//Если выборка прошла, возвращаем успешное сообщение и массив елементов
		$items = array();
		while($row = mysql_fetch_assoc($res)){
			$items[] = $row;
		}
		$res_return = array("answer" => "OK", "mass" => $items);
 	}else{
		//Если произошла ошибка - возвращаем текст ошибки
		$res_return = array("answer" => "SQL error in module galerys_get.\n\r".mysql_error());
	}

    echo json_encode($res_return);


?>