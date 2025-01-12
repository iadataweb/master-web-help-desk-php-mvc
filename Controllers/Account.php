<?php 

	class Account extends Controllers{
		
		public function __construct()
		{
			parent::__construct();
			session_start();
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
				die();
			}
			check_user_status($_SESSION['user_data']['id_user']);
		}

        public function personal_data()
		{
			if ($_SESSION['status_active_user'] === 0) {
				header("Location: " . base_url() . "/account/logout");
				die();
			}
			$data['page_functions_js'] = "functions_personal_data.js";
			$this->views->getView($this, "personal_data", $data);
		}

		public function change_password()
		{
			if ($_SESSION['status_active_user'] === 0) {
				header("Location: " . base_url() . "/account/logout");
				die();
			}
			$data['page_functions_js'] = "functions_change_password.js";
			$this->views->getView($this, "change_password", $data);
		}

		public function update_personal_data()
		{
			if ($_SESSION['status_active_user'] === 0) {
				$response = array("status" => false, "type" => "error", "message" => "Tu cuenta de usuario no está activa.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			if(!empty($_POST)){
				if (empty($_POST['first_names_user'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, ingrese el nombre completo.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if (empty($_POST['last_names_user'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, ingrese el apellido completo.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if (empty($_POST['email_user'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, ingrese el correo electrónico.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if (!filter_var($_POST['email_user'], FILTER_VALIDATE_EMAIL)) {
					$response = array("status" => false, "type" => "error", "message" => "El email ingresado no es válido.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if (empty($_POST['cell_phone_user'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, ingrese el teléfono / celular.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if (!filter_var($_POST['cell_phone_user'], FILTER_VALIDATE_INT)) {
					$response = array("status" => false, "type" => "error", "message" => "El número de celular no es válido.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if (strlen($_POST['cell_phone_user']) !== 9) {
					$response = array("status" => false, "type" => "error", "message" => "El número de celular debe tener exactamente 9 dígitos.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				$int_id_user = $_SESSION['user_data']['id_user'];
				$str_first_names_user = trim($_POST['first_names_user']);
				$str_last_names_user = trim($_POST['last_names_user']);
				$str_email_user = trim($_POST['email_user']);
				$int_cell_phone_user = str_replace(' ', '', trim($_POST['cell_phone_user']));
				$request_user = $this->model->update_personal_data($int_id_user, $str_first_names_user, $str_last_names_user, $str_email_user, $int_cell_phone_user);
				if($request_user) {
					session_user($_SESSION['id_user']);
					$response = array("status" => true, "type" => "success", "message" => "Datos actualizados correctamente.");
				} else {
					$response = array("status" => false, "type" => "error", "message" => "Error al actualizar los datos.");
				}
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
			} else {
				$response = array("status" => false, "type" => "error", "message" => "No se enviaron datos.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function update_password()
		{
			if ($_SESSION['status_active_user'] === 0) {
				$response = array("status" => false, "type" => "error", "message" => "Tu cuenta de usuario no está activa.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			if(!empty($_POST)){
				if (empty($_POST['current_password'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, ingrese la contraseña actual.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if (empty($_POST['new_password'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, ingrese la nueva contraseña.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if (empty($_POST['repeat_password'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, repetir la nueva contraseña.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				$int_id_user = $_SESSION['user_data']['id_user'];
				$str_current_password = $_POST['current_password'];
				$str_new_password = $_POST['new_password'];
				$str_repeat_password = $_POST['repeat_password'];
				$request_validate_password = $this->model->validate_password($int_id_user, $str_current_password);
				if ($request_validate_password) {
					if ($str_new_password === $str_repeat_password) {
						$hashed_password = password_hash($str_new_password, PASSWORD_DEFAULT);
						$request_update_password = $this->model->update_password($int_id_user, $hashed_password);
						if ($request_update_password) {
							$response = array("status" => true, "type" => "success", "message" => "La contraseña se actualizó correctamente.");
						} else {
							$response = array("status" => false, "type" => "error", "message" => "Error al actualizar la contraseña.");
						}
					} else {
						$response = array("status" => false, "type" => "error", "message" => "Las nuevas contraseñas no coinciden.");
					}
				} else {
					$response = array("status" => false, "type" => "error", "message" => "La contraseña actual no es válida.");
				}
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
			} else {
				$response = array("status" => false, "type" => "error", "message" => "No se enviaron datos.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function logout()
		{
			session_unset();
			session_destroy();
			header('location: '.base_url().'/login');
			die();
		}

	}
 ?>