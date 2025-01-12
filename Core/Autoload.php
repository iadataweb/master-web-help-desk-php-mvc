<?php 
	spl_autoload_register(function($class){
		if(file_exists("Core/".$class.".php")){
			require_once("Core/".$class.".php");
		}
	});
?>