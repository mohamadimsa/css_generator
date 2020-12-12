<?php 
// fonction permettant de recuperer la taille d'image pour l'option -o
function recup_size(string $size){
   global	$siz;
	$width = strrev($size);
	$width = substr(strrchr($width, "x"), 1);
	$width = strrev($width);
	$width =intval($width);
  $height = substr(strrchr($size, "x"), 1);
  $height =intval($height);
 $siz["height"] = $height;
 $siz["width"]  = $width;
  
  }
//function permettant de verifier que les argument passer sont bien valide pour l'option -o
function verif_o($argument){
	$caratere_spe = '/[^a-zA-Z0-9\ \\\\\/\.\'\\\\"]/m';
	$carater_alpha = '/[a-wA-Wy-zX-Z]/m';
	preg_match_all($caratere_spe, $argument, $c_s, PREG_SET_ORDER, 0);
	preg_match_all($carater_alpha, $argument, $c_a, PREG_SET_ORDER, 0);

	if(count($c_s)> 0 || count($c_a)>0) {
		return false;
	}
	elseif(substr_count($argument, 'x') != 1){
		return false;
	}
	else{return true;};

}
// fonction permettant de cree un sprite dans le dossier indiquer en argv[1]
function merge_dir_select(string $path ,string $name = "NULL" , bool $option = false , bool $recur = false){

	if(file_exists($path) && is_dir($path) && $recur == false){

		if(is_writable($path)){
			chdir($path);

		if(error_image()=== false){

			if($option == false){
				generate_css();
				merge_image(charge_image(),$name);
			}
			else{
				generate_css($name);
				merge_image(charge_image());
			}
		    
			
		}

		else{
			  echo"le nombre d'image présent dans le dossier ne permet pas de lancer le programe".PHP_EOL.PHP_EOL;

			  man();
		}
		
		}else{echo"le dossier n'est pas accessible veuillez verifier qui vous détenez bien de droit accés".PHP_EOL.PHP_EOL;
			 
			man();
		}  
	}
	elseif(file_exists($path) && is_dir($path) && $recur != false){
		if(is_writable($path)){
			chdir($path);
			recur();
		}
		else{ echo "error : le dossier n'est pas accesible en écriture\n";}
		
		}
		
	else{
		echo "le dossier que vous avez indiquer n'existe pas".PHP_EOL.PHP_EOL;

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
   $search_pictures = glob("*.png");
	
	if(count($search_pictures) === 0){
		return true;}
	elseif(count($search_pictures) <2){
	   return true;
	}
	else{return false;}
}
// function permettant de charger et redimentioner les images

 function charge_image($image_charge, int $width =800, int $height = 740){

	for($i = 0; $i < count($image_charge);$i++){
	  $image[$i] = imagecreatefrompng($image_charge[$i]);
		resize($image_charge[$i], $i,$width,$height);
  }   
	  $image_resize = glob("*resize.png");

	  for($i = 0; $i < count($image_resize);$i++){
		$image_r[$i] = imagecreatefrompng($image_resize[$i]);

  } 
      return $image_r;  
  }

// function permettant de generer du css
function generate_css(array $images,string $name = "style"){  
	  global $w;
	  global $h;
		
	$name_css = $name.".css";
	   if(file_exists("$name_css")){unlink("$name_css");}

	   
	  
	   $name_ima ="";
			$name_image = fopen("$name_css", "a+");
			for($i = 0 ; $i < count($images);$i++){
			   $name_ima .= ".".$images[$i].", ";
		 }
		  
		 $name_ima .= "\n{\n display: inline-block;\n background: url('sprite.png') no-repeat;\n overflow: hidden;\n text-indent: -9999px;\n text-align: left;\n }\n\n";
		 
	      
		  for($i = 0 ; $i < count($images);$i++){
			  $positon = $i*$h;
			 $name_ima .= ".".$images[$i]."{\n background-position: -0px $positon"."px;\n width: ".$w."px;\n height: ".$h."px;\n }\n\n";
	
		  }
		  fwrite($name_image ,$name_ima);
	
		  fclose($name_image);
}

// Fonction permettant de concaténer tous images se trouvant dans le dossier courant

function merge_image(array $resource, string $name_picture = "sprite"){
		global $w;
		global $h;

	 $taille= $h *count($resource);
	 

	$destination = imagecreatetruecolor($w,$taille);
       
		for($i = 0; $i < count($resource);$i++){
		
		imagecopymerge($destination, $resource[$i], 0, $i*$h, 0, 0, $w, $h, 100);
 
		}
		

   imagepng($destination, "$name_picture.png");
   

   foreach(glob("*resize.png") as $value){
	unlink($value);
  }
}

//fonction permettant de redimensionner les images avec une hauteur et largeur maxi de 200px

function resize($picture , int $num_image, int $width = 800 , int $height = 740){


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

 $GLOBALS['w'] = $width;
 $GLOBALS['h'] = $height;

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
		echo "   -s, --output-style=STYLE     Nom de la feuille de style générée. S'il est vide, le nom par défaut est «style.css».\n".PHP_EOL;
		echo "   -o, --override-size=SIZE     Forcer chaque image du sprite à s'adapter à une taille de SIZExSIZE pixels.\n".PHP_EOL;
	}

 // fonction 
 
 function recur(){

	$dossier = [];
$i = -1;
if ($handle = opendir('.')) {
  while (false !== ($entry = readdir($handle))) {
    
      if ($entry != "." && $entry != "..") {
          if(is_dir($entry) && is_readable($entry) &&  $entry != ".git"){
            $i ++;
            $dossier[$i] = $entry;
          }
      }
  }
  closedir($handle);
}

$im_t = [];
for($i = 0 ; $i < count($dossier);$i++)
{
  if ($handle = opendir($dossier[$i])) {
    $entry = readdir($handle);
     $tr_dos = getcwd();
     $tr_dos .= "/".$dossier[$i];
    
     chdir($tr_dos);
     $im = glob("*png");
     if(count($im)> 0){
        
          foreach($im as $value){

            array_push($im_t,getcwd()."/".$value);
          }
           
      
     }
     
    $dos_courant = dirname(getcwd());
    chdir($dos_courant);
     
    }
}
if(count($im_t)>0){
for($i = 0; count($im_t) > $i; $i++){

$imagename = substr(strrchr($im_t[$i], "/"), 1);
$name_do = strrev($im_t[$i]);
$name_do = strstr($name_do, '/');
$name_do = substr($name_do,1);
$name_do = strrev($name_do);
$name_do = substr(strrchr($name_do, "/"), 1);
$path_image[$i] = $name_do."/".$imagename;

}
}

$image_dc = glob("*png");
for($i = 0;count($image_dc) > $i ; $i++)
{
  $imageamerge[$i] = $image_dc[$i];
}
if( isset($path_image)  && count($path_image) > 0){
   foreach($path_image as $value)
   {
     array_push($imageamerge,$value);
   }




}
merge_image(charge_image($imageamerge));
foreach($imageamerge as $key => $value){
  
  if(false !== (substr(strrchr($value, "/"), 1) )){
      $imageamerge[$key] = substr(strrchr($value, "/"), 1);
  }
   
}
  
d($imageamerge);
 generate_css($imageamerge);

 }