<?php 
	
	class Views
	{
		function getView($controller, $view, $data="")
		{
			$controller = get_class($controller);
			$view = "Views/".$controller."/".$view.".php";
			require_once ($view);
		}
	}
	
 ?>