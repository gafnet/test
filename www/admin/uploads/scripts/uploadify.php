<?php
/* defined('ISHOP') or die('Access denied'); 

Uploadify v2.1.0
Release Date: August 24, 2009

Copyright (c) 2009 Ronnie Garcia, Travis Nickels

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/

	$file_name='log.txt'; // 1
	$w=fopen($file_name,'w'); // 6
	fwrite($w,"\n Зашли в файл загрузки");  // 7
if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
    
    if(!$_REQUEST[folder]) $folder = '../'; // Если в js-части мы не определили директорию загрузки, мы можем сделать это здесь
    else $folder = $_REQUEST['folder'];

	
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $folder;
	$galery_id = 1;
	$pk_user = 1;
	/*
	$pk_user = strripos( $folder, '/');
	if ($pk_user == False) {$pk_user = 0;} 
	else {$pk_user = substr($folder, $pk_user+1);}

	mkdir($targetPath);
	*/
	
	
		fwrite($w,"\n QUERY_STRING - ".$_SERVER['QUERY_STRING']);  // 7
	$targetPath = $targetPath . '/';
	$ext = preg_replace('/(?:.*)(\.{1}[a-zA-Z]{3,4})$/','$1', $_FILES['Filedata']['name']); // определяем расширение загружаемого файла
	$unic_name  = time().'_'.rand(0,1000).$ext;
    $targetFile =  str_replace('//','/',$targetPath) . $unic_name;

	

		
		if (move_uploaded_file($tempFile,$targetFile)) {
			//Формируем маенькую картинку, и помещаем ее в папку [thumb]
			include ('create_thumbnail.php');
			//Добавляем информацию о загруженном файле в базу данных
			include ('../../../../config.php');
			fwrite($w,"\n DB - ".$DB);  // 7
			fwrite($w,"\n PATH - ".PATH);  // 7
			$path_for_file = str_replace( PATH, "", $folder."/".$unic_name);
			$path_for_file_thumb = str_replace( PATH, "", $folder."/thumb/".$unic_name);
			$ext = substr($ext, 1);
			$sql_text="INSERT INTO files (galery_id, file_nam, path, path_small, type, size, pk_user) 
						VALUES ($galery_id, '".$_FILES['Filedata']['name']."', '".$path_for_file."', '".$path_for_file_thumb."','".$ext."', ".($_FILES['Filedata']['size']/1024).", $pk_user)";
			fwrite($w,"\n SQL - ".$sql_text);  // 7
			$result = mysql_query($sql_text, DB);
			if(!$result) {
			fwrite($w,"\n Error - ".mysql_error());  // 7
			
			}			

			echo "1"; // Отправляем ответ. Например, просто 1
		}
		else {
		}

}

		fclose($w);  // 8
?>