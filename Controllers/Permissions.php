<?php 

	class Permissions extends Controllers{
		
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

		public function show_permissions() {
			if ($_SESSION['status_active_user'] === 0) {
				header("Location: " . base_url() . "/account/logout");
				die();
			}
			$int_id_role = trim($_POST['id_role']);
			$data_modules = $this->model->select_modules();
			$request_permissions_check = $this->model->check_permissions($int_id_role);
			if ($request_permissions_check[0]["total"] > 0) {
				$request_permissions = $this->model->show_permissions($int_id_role);
				$data['permissions_modules'] = $request_permissions;
			} else {
				for ($i=0; $i < count($data_modules) ; $i++) { 
					$data_modules[$i]["r_read_permission"] = 0;
					$data_modules[$i]["w_write_permission"] = 0;
					$data_modules[$i]["u_update_permission"] = 0;
					$data_modules[$i]["d_delete_permission"] = 0;
				}
				$data['permissions_modules'] = $data_modules;
			}
			$html = modal_permissions($data);
			die();
		}

		public function insert_or_update_permission() 
		{
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
				$int_modules = $_POST['modules'];
				$request_permissions_check = $this->model->check_permissions($int_id_role);
				foreach ($int_modules as $module) {
					$id_module = $module['id_module'];
					$r = empty($module['r']) ? 0 : 1;
					$w = empty($module['w']) ? 0 : 1;
					$u = empty($module['u']) ? 0 : 1;
					$d = empty($module['d']) ? 0 : 1;

					if ($request_permissions_check[0]["total"] > 0) {
						$request_permission = $this->model->update_permission($int_id_role, $id_module, $r, $w, $u, $d);
					} else {
						$request_permission = $this->model->insert_permission($int_id_role, $id_module, $r, $w, $u, $d);
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