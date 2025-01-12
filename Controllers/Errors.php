<?php 
	class Errors extends Controllers{
		
		public function __construct()
		{
			parent::__construct();
		}

		public function forbidden()
		{
			$this->views->getView($this, "403");
		}

		public function not_found()
		{
			$this->views->getView($this, "404");
		}

		public function system_error()
		{
			$this->views->getView($this, "500");
		}
	}
?>