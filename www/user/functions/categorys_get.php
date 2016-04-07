<?php 
define('WOOD', TRUE);
include_once '../../config.php';

if($_POST['parent_id']){
	$parent_id = (int)$_POST['parent_id'];
	
    $query = "SELECT * FROM category WHERE parent_id = $parent_id ORDER BY position";
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
		$res_return = array("answer" => "SQL error in module categorys_get.\n\r".mysql_error());
	}


}else {
	$res_return = array("answer" => "Не передан parent_id");
	
}
    echo json_encode($res_return);
?>