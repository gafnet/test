<?php defined('ISHOP') or die('Access denied'); ?>

<div class="highslide-gallery">
<table align='center' class='post' cellspacing='0'>
<tr>
	<td class='content_header' width='1%'>

	</td>
	<td class='content_header' width='40%'>
	Путь к файлу
	</td>
	<td class='content_header'>
	Тип файла
	</td>
	<td class='content_header'>
	Размер
	</td>
	<td class='content_header'>
	</td>
</tr>

<?php
$sql = "SELECT * FROM files WHERE pk_user = " . $objCore->getSessionInfo()->getUserInfo('pk_user');
$query = mysql_query($sql, $db);
if (!$query) {
	echo mysql_error();
}
else {
	if (mysql_num_rows($query) > 0) {
		while($row = mysql_fetch_assoc($query)) {
			$data[$row[file_id]] = $row; 
		}
	}
	else {echo "Данных нет.";}
}

function filesToTemplate($files)
{
    /* $comment - массив комментария - имя, дата, коммент, потомки (если есть) */
    
    /* Включаем буферизацию вывода, чтобы шаблон не вывелся в месте вызова функции.
    */
    ob_start();  
      
        // Подключаем шаблон  comment_template.php, который просто таки ждет наш массив $comment ))
        include 'files_template.php';                     
    
    $files_string =  ob_get_contents(); // Получаем содержимое буфера в виде строки
    ob_end_clean(); // очищаем буфер
    
    return $files_string;
    // Можно применить более короткую запись - return ob_get_clean(); вместо     $comments_string =  ob_get_contents(); ob_end_clean(); return $comments_string;
} 

function filesString($data) {
	foreach($data as $w) {
		$string .= filesToTemplate($w);
	}
return $string; 
} 

$files = filesString($data);
$data = null;
echo $files;

?>

</table>
</div>

<div id="demo">
    
    <h3>Загрузка файлов на сервер:</h3>
    <div id="fileQueue"></div>
    <input type="file" name="uploadify" id="uploadify" />
	<input id='folder_upload' type="hidden" value='uploads/<?php echo $objCore->getSessionInfo()->getUserInfo('pk_user'); ?>' />
    <div id="info"></div>
    <div id="info2"></div>
</div>

<? include_once (ABSPATH . MASTER_PAGE . 'footer.php'); ?>