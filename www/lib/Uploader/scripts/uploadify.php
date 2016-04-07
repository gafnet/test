<?php
/*
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
    
//	imagecopyresampled( $resultImage, $sourceImage, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
/* 	if (function_exists('exif_read_data')) {
		$exif = exif_read_data( $img, 0, true);
		if( false === empty( $exif['IFD0']['Orientation'] ) ) {
		switch( $exif['IFD0']['Orientation'] ) {
			case 8:
				$newImg = imagerotate( $newImg, 90, 0 );
				break;
			case 3:
				$newImg = imagerotate( $newImg,180,0);
				break;
			case 6:
				$newImg = imagerotate( $newImg,-90,0);
				break;
		}
	} 
}
 */
	
	
	
	imagedestroy($newImg);
}
/* ===Ресайз картинок=== */


if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
    
    if(!$_REQUEST[folder]) $folder = '../uploads/'; // Если в js-части мы не определили директорию загрузки, мы можем сделать это здесь
    else $folder = $_REQUEST['folder'];
    
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $folder . '/';
	$targetPath = str_replace('//','/',$targetPath);
	$ext = preg_replace('/(?:.*)(\.{1}[a-zA-Z]{3,4})$/','$1', $_FILES['Filedata']['name']); // определяем расширение загружаемого файла
	$unic_name  = time().'_'.rand(0,1000).$ext;
    $targetFile =  $targetPath . $unic_name;
	
	

		
	if(@move_uploaded_file($tempFile,$targetFile)){
		resize($targetFile, $targetPath . "m_" . $unic_name, 300, 800, $ext);
		//echo "m_" . $unic_name; // Отправляем ответ. Например, просто 1
		//Получаем высоту и ширину загруженного среднего файла
		list($w_orig, $h_orig) = getimagesize($targetPath . "m_" . $unic_name);
		$ratio = $w_orig / $h_orig; // =1 - квадрат, <1 - альбомная, >1 - книжная
		if($ratio>1){
			$area_select = '"x1":'.intval(($w_orig-$h_orig)/2).', "y1":0, "x2":' . intval($h_orig+($w_orig-$h_orig)/2) . ' , "y2":' . $h_orig;
		}else{
			$area_select = '"y1":'.intval(($h_orig - $w_orig)/2).', "x1":0, "y2":' . intval($w_orig+($h_orig - $w_orig)/2) . ' , "x2":' . $w_orig;
		}
		$res_return = '{"answer" : "OK", "file" : "m_' . $unic_name . '",'.$area_select.'}';
		echo $res_return;
	}
}
?>