<?php 

	class AdditionalPermissions extends Controllers{
		
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

		public function show_additional_permissions() {
			if ($_SESSION['status_active_user'] === 0) {
				header("Location: " . base_url() . "/account/logout");
				die();
			}
			$int_id_role = trim($_POST['id_role']);
			$data_controls = $this->model->select_controls();
			$request_additional_permissions_check = $this->model->check_additional_permissions($int_id_role);
			if ($request_additional_permissions_check[0]["total"] > 0) {
				$request_additional_permissions = $this->model->show_additional_permissions($int_id_role);
				$data['additional_permissions'] = $request_additional_permissions;
			} else {
				for ($i=0; $i < count($data_controls) ; $i++) { 
					$data_controls[$i]["allow_additional_permission"] = 0;
				}
				$data['additional_permissions'] = $data_controls;
			}
			$html = modal_additional_permissions($data);
			die();
		}

		public function insert_or_update_additional_permission() {
			if ($_SESSION['status_active_user'] === 0) {
				$response = array("status" => false, "type" => "error", "message" => "Tu cuenta de usuario no está activa.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			if (!empty($_POST)) {
				if (empty($_POST['id_role'])) {
					$response = array("status" => false, "type" => "error", "message" => "Ocurrió un error, por favor, reinicia el navegador.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if ($_POST['id_role'] == ROLE_SUPER_ADMINISTRATOR) {
					$response = array("status" => false, "type" => "error", "message" => "No se puede editar los permisos del rol de super administrador.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				$int_id_role = trim($_POST['id_role']);
				$int_controls = $_POST['controls'];
				$request_additional_permissions_check = $this->model->check_additional_permissions($int_id_role);
				foreach ($int_controls as $control) {
					$id_control = $control['id_control'];
					$allow = empty($control['allow']) ? 0 : 1;

					if ($request_additional_permissions_check[0]["total"] > 0) {
						$request_permission = $this->model->update_additional_permission($int_id_role, $id_control, $allow);
					} else {
						$request_permission = $this->model->insert_additional_permission($int_id_role, $id_control, $allow);
					}
				}
				if ($request_permission) {
					$response = array("status" => true, "type" => "success", "message" => "Actualizado correctamente.");
				} else {
					$response = array("status" => false, "type" => "error", "message" => "No se pudo actualizar el registro.");
				}
			} else {
				$response = array("status" => false, "type" => "error", "message" => "No se enviaron datos.");
			}
			echo json_encode($response, JSON_UNESCAPED_UNICODE);
			die();
		}

	}
?>