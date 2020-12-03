<?php 

function search_pictures(){
    
}


function my_merge_image($first_img_path, $second_img_path)
 {
 	#         charger les image 

 	$source_1 = imagecreatefrompng($first_img_path);
 	$source_2 = imagecreatefrompng($second_img_path);
 	$destination = imagecreatetruecolor(1000,1000);
    
    #     renvoyer la largeur et la hauteur des image 

 	$largeur_source_1 = imagesx($source_1);
 	$hauteur_source_1 = imagesy($source_1);
 	$largeur_source_2 = imagesx($source_2);
 	$hauteur_source_2 = imagesy($source_2);
    
   #     copies les image dans la destination

   imagecopymerge($destination, $source_1 , 0, 0, 0, 0, $largeur_source_1, $hauteur_source_1 , 100);
   imagecopymerge($destination, $source_2, 150, 450, 0, 0, $largeur_source_2, $hauteur_source_2, 100);
    #   creation l'image fusion 
  header("Content-type: image/png");
  imagepng($destination, 'test.png'); 
}