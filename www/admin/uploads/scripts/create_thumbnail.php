<?php

  ini_set("display_errors", "1");
  error_reporting(E_ALL); 
  
  $img_src = $targetFile;
  //Желаемая ширина пиктограммы 
  $width = 125;
  //Имя пиктограммы
  $targetPath = $targetPath . 'thumb';


  //mkdir($targetPath);
  $targetPath = $targetPath . '/';
  $targetFile =  str_replace('//','/',$targetPath) . $unic_name;
  $thumb = $targetFile;
  


		
  
  
  // Подтверждаем, что изображение существует 
  if(file_exists($img_src)){
  //Вывод изображения 
  $image = imagecreatefromjpeg($img_src);
  
  // Проверяем данные о ширине и высоте и сохраняем их 
  list($image_width, $image_height) = getimagesize($img_src);
  
  // Высчитываем новую высоту, сохраняя пропорциональность
  $height = (($width / $image_width) * $image_height);
  
  // производим повторную выборку и изменяем размер изображения 
  $tmp_img = imagecreatetruecolor($width, $height);

  imagecopyresampled($tmp_img, $image, 0, 0, 0, 0, $width, $height, $image_width, $image_height);
  
  //Пытаемся сохранить новую пиктограмму 
  if(is_writeable(dirname($thumb))){
  imagejpeg($tmp_img, $thumb, 100);
  echo 'Thumbnail saved as ' , $thumb;
  }
  else {
  echo 'Unable to save thumbnail, please check file and directory permissions.';
  }
  
  // Очищаем память
  imagedestroy($tmp_img);
  imagedestroy($image);
  }

  else {
  echo 'File not found!';
  }
 
  ?>