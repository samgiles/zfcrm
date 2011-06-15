<?php

function write_ini_file($assoc_array, $path) {
	$content = '';
   foreach ($assoc_array as $key => $item) {
       if (is_array($item)) {
           $content .= "\n[$key]\n";
           foreach ($item as $key2 => $item2) {
           	   if (is_array($item2) && count($item2) > 0){
           	   	$content .= $key2 .'[]' . "= \n"; 
           	   } else {
                $content .= "$key2 = \"$item2\"\n";
           	   }
           }       
       } else {
           $content .= "$key = \"$item\"\n";
       }
   }       
  
   if (!$handle = fopen($path, 'w')) {
       return false;
   }
   if (!fwrite($handle, $content)) {
       return false;
   }
   fclose($handle);
   return true;
}

function append_to_application_config($section, $array){
	    $ini = parse_ini_file(APPLICATION_PATH . '/configs/application.ini', true);

    	$ini[$section] = array_merge($ini[$section], $array);

    	echo '<pre>';
    	print_r($ini);
    	echo '</pre>';
    	
    	write_ini_file($ini, APPLICATION_PATH . '/configs/application.ini');   	
}