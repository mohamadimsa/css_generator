<?php 



function my_merge_image()
 {
 	#   charger les image 

 	$source_1 = imagecreatefrompng($first_img_path);
 	$source_2 = imagecreatefrompng($second_img_path);
 	$destination = imagecreatetruecolor(1000,1000);
    
    #   renvoyer la largeur et la hauteur des image 0368985170

 	$largeur_source_1 = imagesx($source_1);
 	$hauteur_source_1 = imagesy($source_1);
 	$largeur_source_2 = imagesx($source_2);
 	$hauteur_source_2 = imagesy($source_2);
    
   #    copies les image dans la destination

   imagecopymerge($destination, $source_1 , 0, 0, 0, 0, $largeur_source_1, $hauteur_source_1 , 100);
   imagecopymerge($destination, $source_2, 150, 450, 0, 0, $largeur_source_2, $hauteur_source_2, 100);

	#   creation l'image fusion 
	
   header("Content-type: image/png");
   imagepng($destination, 'merge.png');
}

function merge_image($resource){


	$destination = imagecreatetruecolor(1000,1000);

	

		for($i = 0; $i < count($resource);$i++){
			
		imagecopymerge($destination, $resource[$i] , 0, $i*200, 0, 0, 200, 200, 100);
 
		}
		 

   imagepng($destination, 'merge.png');

   foreach(glob("*resize.png") as $value){
	unlink($value);
   }
}

function resize($picture , int $num_image){
   
	if(!file_exists("resize")){
		mkdir("resize",0700 );
	}
	
   
	// largeur et hauteur maximal

$width = 200;
$height = 200;

	//calcule des nouvelle dimention  

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
 
 // Affichage

 
 imagepng($image_p, $num_image."resize.png");

 }

 function d($variable){
	 var_dump($variable);
 }