<?php 
// recursive revoir function recur

// fonction permettant de cree un sprite dans le dossier indiquer en argv[1]
function merge_dir_select(string $path){

	if(file_exists($path) && is_dir($path)){
		generate_css();
	  merge_image(charge_image());  
	}
	
}

// fonction permettant de recupérer le nom de l'image passer en argv[2]
function recupe_name(string $option){
  $cute = strstr($option, "=");
  $name = substr($cute,1);
  return $name;
}
// fonction regex 

function regex(string $reg, string $str){
$pattern = "/$reg/i";
$result = preg_match($pattern, $str);
if($result == 1){
	return true;
}
else{return false ;}
}

//fonction qui renvois un message d'erreur si le nombre d'image png et inferieure a 1 ou inexistant 

function error_image(){
    global $search_pictures;
	if(empty($search_pictures)){
		return 0;}
	if(count($search_pictures) <2){
	   return 0;
	}
return 1;
}
// function permettant de charger et redimentioner les images

 function charge_image(){

	  global $search_pictures;

	for($i = 0; $i < count($search_pictures);$i++){
	  $image[$i] = imagecreatefrompng($search_pictures[$i]);
		resize($search_pictures[$i], $i);
  }   

	  $image_resize = glob("*resize.png");

	  for($i = 0; $i < count($image_resize);$i++){
		$image_r[$i] = imagecreatefrompng($image_resize[$i]);

  } 
      return $image_r;  
  }

// function permettant de generer du css
function generate_css(string $name = "style"){  
	
	$name_css = $name.".css";
	   if(file_exists("$name_css")){unlink("$name_css");}
	   
	   $images = glob("*.png");
	   $name_ima ="";
			$name_image = fopen("$name_css", "a+");
			for($i = 0 ; $i < count($images);$i++){
			   $name_ima .= ".".$images[$i].", ";
		 }
		  
		 $name_ima .= "\n{\n display: inline-block;\n background: url('sprite.png') no-repeat;\n overflow: hidden;\n text-indent: -9999px;\n text-align: left;\n }\n\n";
		 
	      
		  for($i = 0 ; $i < count($images);$i++){
			  $positon = $i*200;
			 $name_ima .= ".".$images[$i]."{\n background-position: -0px $positon"."px;\n width: 200px;\n height: 200px;\n }\n\n";
	
		  }
		  fwrite($name_image ,$name_ima);
	
		  fclose($name_image);
}

// Fonction permettant de concaténer tous images se trouvant dans le dossier courant

function merge_image(array $resource, string $name_picture = "sprite"){


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
// function debug var_dump en simplifier 
 function d($variable){
	 var_dump($variable);
 }

 // fonction man css_generator

 function man(){

		echo "Utilisation : css_generator [OPTION]...assets_folder ".PHP_EOL;
		echo PHP_EOL;
        echo"Concaténez toutes les images d'un dossier dans un sprite et écris une feuille de style prête à l'emploi.\nLes arguments obligatoires pour les options longues sont également obligatoires pour les options courtes".PHP_EOL;
		echo "\n   -r, --recursive      Recherchez des images dans le dossier assets_folder passé comme argument et dans tous ses sous-répertoires.\n".PHP_EOL;
		echo "   -i, --output-image=IMAGE     Nom de l'image générée. S'il est vide, le nom par défaut est «sprite.png».\n".PHP_EOL;
		echo "   -s, --output-style=STYLE     Nom de la feuille de style générée. S'il est vide, le nom par défaut est «style.css».".PHP_EOL;
	}

 // fonction 
 
 function recur(){
	
 }