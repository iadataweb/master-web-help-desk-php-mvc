<?php 

	$controller = str_replace('_', ' ', $controller);
	$controller = ucwords($controller);
	$controller = str_replace(' ', '', $controller);
	$controllerFile = "Controllers/".$controller.".php";
	if(file_exists($controllerFile))
	{
		require_once($controllerFile);
		$controller = new $controller();
		if(method_exists($controller, $method))
		{
			$controller->{$method}($params);
		}else{
			require_once("Controllers/Errors.php");
			$not_found = new Errors();
			$not_found->not_found();
		}
	}else{
		require_once("Controllers/Errors.php");
		$not_found = new Errors();
		$not_found->not_found();
	}

 ?>