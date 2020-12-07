<?php

function merge_dir_select(string $path){
if(file_exists($path) && is_dir($path)){
    generate_css();
  merge_image(charge_image());  
}

}
change_dir("salut");
var_dump(getcwd());