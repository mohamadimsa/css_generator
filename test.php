<?php
$str ="355x666";
recup_size($str);

print_r($siz);

function recup_size(string $size){
    global $siz;
	$width = strrev($size);
	$width = substr(strrchr($width, "x"), 1);
	$width = strrev($width);
	$width =intval($width);
	  $height = substr(strrchr($size, "x"), 1);
  $height =intval($height);
  $siz["height"] = $height;
  $siz["width"]  = $width;
  }