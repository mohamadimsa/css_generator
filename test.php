<?php

include 'function.php';
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
for($i = 0; count($im_t) > $i; $i++){

  $imagename = substr(strrchr($im_t[$i], "/"), 1);
 $name_do = strrev($im_t[$i]);
 $name_do = strstr($name_do, '/');
$name_do = substr($name_do,1);
$name_do = strrev($name_do);
$name_do = substr(strrchr($name_do, "/"), 1);
$path_image[$i] = $name_do."/".$imagename;

}

d($path_image);