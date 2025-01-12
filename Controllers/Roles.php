<?php 

	class Roles extends Controllers{
		
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

        public function manage_roles()
		{
			if ($_SESSION['status_active_user'] === 0) {
				header("Location: " . base_url() . "/account/logout");
				die();
			}
			check_permissions(MODULE_ROLE_MANAGEMENT);
			if(empty($_SESSION['module_permissions']['r_read_permission'])){
				header("Location:".base_url().'/errors/forbidden');
				die();
			}
			$data['script'] = [
				"/js/language_datatable.js",
				"/extensions/datatables.net/js/jquery.dataTables.min.js",
				"/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js",
				"/static/js/pages/datatables.js"
			];
			$data['page_functions_js'] = "functions_manage_roles.js";
			$this->views->getView($this, "manage", $data);
		}

		public function show_roles()
		{
			if ($_SESSION['status_active_user'] === 0) {
				header("Location: " . base_url() . "/account/logout");
				die();
			}
			check_permissions(MODULE_ROLE_MANAGEMENT);
			if(empty($_SESSION['module_permissions']['r_read_permission'])){
				header("Location:".base_url().'/errors/forbidden');
				die();
			}
			$data = $this->model->show_roles();
			for ($i=0; $i < count($data); $i++) {
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				if($data[$i]['status_active_role'] == 1){
					$data[$i]['status_active_role'] = '<span class="badge bg-success">Activo</span>';
				}else{
					$data[$i]['status_active_role'] = '<span class="badge bg-danger">Inactivo</span>';
				}
				if($_SESSION['module_permissions']['r_read_permission']){
					$btnView = '<button type="button" class="btn icon btn-secondary js-btn-view" data-id="'.$data[$i]['id_role'].'" title="Ver"><i class="bi bi-eye-fill"></i></button>';
				}
				if($_SESSION['module_permissions']['u_update_permission']){
					$btnPermissions = '<button type="button" class="btn icon btn-warning js-btn-permissions" data-id="'.$data[$i]['id_role'].'" title="Permisos"><i class="bi bi-key-fill"></i></button>';
				}
				if($_SESSION['module_permissions']['u_update_permission']){
					$btnAdditionalPermissions = '<button type="button" class="btn icon btn-warning js-btn-additional-permissions" data-id="'.$data[$i]['id_role'].'" title="Permisos Adicionales"><i class="bi bi-card-checklist"></i></button>';
				}
				if($_SESSION['module_permissions']['u_update_permission']){
					$btnEdit = '<button type="button" class="btn icon btn-primary js-btn-edit" data-id="'.$data[$i]['id_role'].'" title="Editar"><i class="bi bi-pencil"></i></button>';
				}
				if($_SESSION['module_permissions']['d_delete_permission']){	
					$btnDelete = '<button type="button" class="btn icon btn-danger js-btn-delete" data-id="'.$data[$i]['id_role'].'" title="Eliminar"><i class="bi bi-trash3-fill"></i></button>';
				}
				$data[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnPermissions.' '.$btnAdditionalPermissions.' '.$btnEdit.' '.$btnDelete.'</div>';
			}
			echo json_encode($data, JSON_UNESCAPED_UNICODE);
		}

		public function show_role() {
			if ($_SESSION['status_active_user'] === 0) {
				$response = array("status" => false, "type" => "error", "message" => "Tu cuenta de usuario no está activa.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			check_permissions(MODULE_ROLE_MANAGEMENT);
			if (!$_SESSION['module_permissions']['r_read_permission']) {
				$response = array("status" => false, "type" => "error", "message" => "No tienes permisos para leer el registro.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			if (!empty($_POST)) {
				if (empty($_POST['id_role'])) {
					$response = array("status" => false, "type" => "error", "message" => "Ocurrió un error, por favor, reinicia el navegador.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				$int_id_role = trim($_POST['id_role']);
				$request_role = $this->model->show_role($int_id_role);
				if ($request_role) {
					$response = array("status" => true, "result" => $request_role);
				} else {
					$response = array("status" => false, "type" => "error", "message" => "No se pudo leer el registro.");
				}
			} else {
				$response = array("status" => false, "type" => "error", "message" => "No se enviaron datos.");
			}
			echo json_encode($response, JSON_UNESCAPED_UNICODE);
			die();
		}
		
		public function insert_role() {
			if ($_SESSION['status_active_user'] === 0) {
				$response = array("status" => false, "type" => "error", "message" => "Tu cuenta de usuario no está activa.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			check_permissions(MODULE_ROLE_MANAGEMENT);
			if (!$_SESSION['module_permissions']['w_write_permission']) {
				$response = array("status" => false, "type" => "error", "message" => "No tienes permisos para registrar nuevo rol.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			if (!empty($_POST)) {
				if (empty($_POST['name_role'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, ingrese el nombre de rol.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if (empty($_POST['description_role'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, ingrese la descripción de rol.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if (!isset($_POST['status_active_role'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, seleccione una opción de estado.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				$str_name_role = trim($_POST['name_role']);
				$str_description_role = trim($_POST['description_role']);
				$int_status_active_role = trim($_POST['status_active_role']);
				$request_role = $this->model->insert_role($str_name_role, $str_description_role, $int_status_active_role);
				if ($request_role) {
					$response = array("status" => true, "type" => "success", "message" => "Registrado correctamente.");
				} else {
					$response = array("status" => false, "type" => "error", "message" => "No se pudo registrar nuevo rol.");
				}
			} else {
				$response = array("status" => false, "type" => "error", "message" => "No se enviaron datos.");
			}
			echo json_encode($response, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function update_role() {
			if ($_SESSION['status_active_user'] === 0) {
				$response = array("status" => false, "type" => "error", "message" => "Tu cuenta de usuario no está activa.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			check_permissions(MODULE_CATEGORY_MANAGEMENT);
			if (!$_SESSION['module_permissions']['u_update_permission']) {
				$response = array("status" => false, "type" => "error", "message" => "No tienes permisos para actualizar el registro.");
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
					$response = array("status" => false, "type" => "error", "message" => "No se puede editar el rol de super administrador del sistema.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if (empty($_POST['name_role'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, ingrese el nombre de rol.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if (empty($_POST['description_role'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, ingrese la descripción de rol.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if (!isset($_POST['status_active_role'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, seleccione una opción de estado.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				$int_id_role = trim($_POST['id_role']);
				$str_name_role = trim($_POST['name_role']);
				$str_description_role = trim($_POST['description_role']);
				$int_status_active_role = trim($_POST['status_active_role']);

				$request_role = $this->model->update_role($int_id_role, $str_name_role, $str_description_role, $int_status_active_role);
				if ($request_role) {
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

		public function delete_role() {
			if ($_SESSION['status_active_user'] === 0) {
				$response = array("status" => false, "type" => "error", "message" => "Tu cuenta de usuario no está activa.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			check_permissions(MODULE_CATEGORY_MANAGEMENT);
			if (!$_SESSION['module_permissions']['d_delete_permission']) {
				$response = array("status" => false, "type" => "error", "message" => "No tienes permisos para eliminar el registro.");
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
					$response = array("status" => false, "type" => "error", "message" => "No se puede eliminar el rol de super administrador del sistema.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				$int_id_role = trim($_POST['id_role']);
				$request_role = $this->model->delete_role($int_id_role);
				if ($request_role) {
					$response = array("status" => true, "type" => "success", "message" => "Eliminado correctamente.");
				} else {
					$response = array("status" => false, "type" => "error", "message" => "No se pudo eliminar el registro.");
				}
			} else {
				$response = array("status" => false, "type" => "error", "message" => "No se enviaron datos.");
			}
			echo json_encode($response, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function combo_roles(){
			$data = $this->model->combo_roles();
			$html="";
			$html.="<option selected disabled value=''>Selecciona una opción</option>";
			if(is_array($data) == true and count($data) > 0){
				foreach($data as $row)
				{
					$html.= "<option value='".$row['id_role']."'>".$row['name_role']."</option>";
				}
				echo $html;
			}
		}

	}
?>