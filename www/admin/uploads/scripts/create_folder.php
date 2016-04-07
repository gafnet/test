<?php
	define("OK_ENTER", "yes");
	//Определяем папку заагрузки файлов, в зависимости от пользователя
		
		$file_name='log.txt'; // 1
		$w=fopen($file_name,'w'); // 6
		fwrite($w," ABSPATH - ".ABSPATH);  // 7
		fwrite($w," folder - ".$targetPath);  // 7

		mkdir($targetPath);
		
		fclose($w);  // 8
	//mkdir($targetPath . '1');
	
		
?>
