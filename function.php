<?php 


// function permettant de generer du css
function generate_css(){  
	
	   if(file_exists("style.css")){unlink ("style.css");}
	   
	   $images = glob("*.png");
	   $name_ima ="";
			$name_image = fopen("style.css", "a+");
			for($i = 0 ; $i < count($images);$i++){
			   $name_ima .= ".".$images[$i].", ";
		 }
		  
		 $name_ima .= "\n{ display: inline-block; background: url('sprite.png') no-repeat; overflow: hidden; text-indent: -9999px; text-align: left; }\n";
		  
		 
	
		  for($i = 0 ; $i < count($images);$i++){
			 $name_ima .= ".".$images[$i]."{ background-position: -0px -0px; width: 1600px; height: 900px; }\n";
	
		  }
		  fwrite($name_image ,$name_ima);
	
		  fclose($name_image);
	
}

// Fonction permettant de concaténer tous images se trouvant dans le dossier courant

function merge_image($resource, $name_picture = "sprite"){


	 $taille= 200 *count($resource);
	 

	$destination = imagecreatetruecolor(200,$taille);
       
		for($i = 0; $i < count($resource);$i++){
		
		imagecopymerge($destination, $resource[$i], 0, $i*200, 0, 0, 200, 200, 100);
 
		}
		

   imagepng($destination, "$name_picture.png");
   

   foreach(glob("*resize.png") as $value){
	unlink($value);
   }
}

//fonction permettant de redimensionner les images avec une hauteur et largeur maxi de 200px

function resize($picture , int $num_image){

$width = 200;
$height = 200;


  list($width_orig, $height_orig) = getimagesize($picture);
 $ratio_orig = $width_orig/$height_orig;
 
 if($width/$height > $ratio_orig){

	$width = $height*$ratio_orig;
 }else{
	 $height = $width/$ratio_orig;
 }

 $image_p = imagecreatetruecolor($width, $height);
 $image = imagecreatefrompng($picture);
 imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
 imagepng($image_p, $num_image."resize.png");

 }

 function d($variable){
	 var_dump($variable);
 }