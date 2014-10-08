<?php
/*
 * Author 	Damir Sayapov
 * Email 	d-sayapov@mail.ru
 *
 **/
function imageResize($path, $dstWidth, $dstHeight){
	$dst = imagecreatetruecolor($dstWidth, $dstHeight);
	if(strpos($path, '.jpg') !== FALSE || strpos($path, '.jpeg') !== FALSE){
	    $src = imagecreatefromjpeg($path);
	}
	else if(strpos($path, '.png') !== FALSE){
	    $src = imagecreatefrompng($path);
	}
	else if(strpos($path, '.gif') !== FALSE){
	    $src = imagecreatefromgif($path);
	}

	if($src){
	    $srcX = 0;
	    $srcY = 0;
	    $dstX = 0;
	    $dstY = 0;
	    $srcW = 0;
	    $srcH = 0;

		list($width, $height) = getimagesize($path);
	    
	    //отношения нового размера к старому
	    $d1 = $width / $dstWidth;
	    $d2 = $height / $dstHeight;
	    
	    if($d1 > $d2){
	        //фикс по вертикали
	        //режем по горизонтали
	        $srcX = ($width - ($dstWidth * $d2)) / 2;
	        $srcH = $height;
	        $srcW = $width - $srcX * 2;
	    }
	    else if($d1 < $d2){
	        //фикс по горизонтали
	        //режем по вертикали
	        $srcY = ($height - ($dstHeight * $d1)) / 2;
	        $srcW = $width;
	        $srcH = $height - $srcY * 2;
	    }
	    else{
	        //в квадрат
	        $srcH = $height;
	        $srcW = $width;
	    }
	    
	    $s = imagecopyresampled($dst, $src, $dstX, $dstY, $srcX, $srcY, $dstWidth, $dstHeight, $srcW, $srcH);
	    
	    if(strpos($path, '.jpg') !== FALSE || strpos($path, '.jpeg') !== FALSE){
	        return imagejpeg($dst, $path, 90);
	    }
	    else if(strpos($path, '.png') !== FALSE){
	        return imagepng($dst, $path);
	    }
	    else if(strpos($path, '.gif') !== FALSE){
	        return imagegif($dst, $path);
	    }
	}
	return FALSE;
}