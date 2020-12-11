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
