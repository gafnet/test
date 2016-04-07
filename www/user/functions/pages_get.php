<?php 
define('ISHOP', TRUE);
include_once '../../config.php';

    $query = "SELECT page_id, title, position FROM pages ORDER BY position";
    $res = mysql_query($query);
    
    $items = array();
    while($row = mysql_fetch_assoc($res)){
        $items[] = $row;
    }
    echo json_encode($items);


?>