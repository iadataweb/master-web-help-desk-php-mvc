<?php 

	class Login extends Controllers{
		
		public function __construct()
		{
			session_start();
			if(isset($_SESSION['login']))
			{
				header('Location: '.base_url().'/dashboard');
				die();
			}
			parent::__construct();
		}

		public function login()
		{
			$data['page_functions_js'] = "functions_login.js";
            $this->views->getView($this, "index", $data);
		}

		public function login_user(){
			if($_POST){
				if(empty($_POST['email']) || empty($_POST['password'])){
					$response = array("status" => false, "type" => "error", "message" => "Error de datos.");
				}else{
					if (empty($_POST['email'])) {
						$response = array("status" => false, "type" => "error", "message" => "Por favor, ingrese el correo electrónico.");
						echo json_encode($response, JSON_UNESCAPED_UNICODE);
						return;
					}
					if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
						$response = array("status" => false, "type" => "error", "message" => "El email ingresado no es válido.");
						echo json_encode($response, JSON_UNESCAPED_UNICODE);
						return;
					}
					if (empty($_POST['password'])) {
						$response = array("status" => false, "type" => "error", "message" => "Por favor, ingrese la contraseña.");
						echo json_encode($response, JSON_UNESCAPED_UNICODE);
						return;
					}
					$str_email = trim($_POST['email']);
					$str_password = $_POST['password'];
					$request_user = $this->model->login_user($str_email, $str_password);
					if(empty($request_user)){
                        $response = array("status" => false, "type" => "error", "message" => "El usuario o la contraseña es incorrecto.");

					}else{
						$data = $request_user;
						if($data['status_active_user'] == 1){
							$_SESSION['id_user'] = $data['id_user'];
							$_SESSION['login'] = true;
							$request_session_login = $this->model->session_login($_SESSION['id_user']);
							$_SESSION['user_data'] = $request_session_login;					
                            $response = array("status" => true);
						}else{
                            $response = array("status" => false, "type" => "error", "message" => "Usuario inactivo.");
						}
					}
				}
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

	}
?>