<?php 

	class Priorities extends Controllers{
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

        public function manage_priorities()
		{
			if ($_SESSION['status_active_user'] === 0) {
				header("Location: " . base_url() . "/account/logout");
				die();
			}
			check_permissions(MODULE_PRIORITY_MANAGEMENT);
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
			$data['page_functions_js'] = "functions_manage_priorities.js";
			$this->views->getView($this, "manage", $data);
		}

		public function show_priorities()
		{
			if ($_SESSION['status_active_user'] === 0) {
				header("Location: " . base_url() . "/account/logout");
				die();
			}
			check_permissions(MODULE_PRIORITY_MANAGEMENT);
			if(empty($_SESSION['module_permissions']['r_read_permission'])){
				header("Location:".base_url().'/errors/forbidden');
				die();
			}
			$data = $this->model->show_priorities();
			for ($i=0; $i < count($data); $i++) {
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				if($_SESSION['module_permissions']['r_read_permission']){
					$btnView = '<button type="button" class="btn icon btn-secondary js-btn-view" data-id="'.$data[$i]['id_priority'].'" title="Ver"><i class="bi bi-eye-fill"></i></button>';
				}
				if($_SESSION['module_permissions']['u_update_permission']){
					$btnEdit = '<button type="button" class="btn icon btn-primary js-btn-edit" data-id="'.$data[$i]['id_priority'].'" title="Editar"><i class="bi bi-pencil"></i></button>';
				}
				if($_SESSION['module_permissions']['d_delete_permission']){	
					$btnDelete = '<button type="button" class="btn icon btn-danger js-btn-delete" data-id="'.$data[$i]['id_priority'].'" title="Eliminar"><i class="bi bi-trash3-fill"></i></button>';
				}
				$data[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
			}
			echo json_encode($data, JSON_UNESCAPED_UNICODE);
		}

		public function show_priority() 
		{
			if ($_SESSION['status_active_user'] === 0) {
				$response = array("status" => false, "type" => "error", "message" => "Tu cuenta de usuario no está activa.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			check_permissions(MODULE_PRIORITY_MANAGEMENT);
			if (!$_SESSION['module_permissions']['r_read_permission']) {
				$response = array("status" => false, "type" => "error", "message" => "No tienes permisos para leer el registro.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			if (!empty($_POST)) {
				if (empty($_POST['id_priority'])) {
					$response = array("status" => false, "type" => "error", "message" => "Ocurrió un error, por favor, reinicia el navegador.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				$int_id_priority = trim($_POST['id_priority']);
				$request_priority = $this->model->show_priority($int_id_priority);
				if ($request_priority) {
					$response = array("status" => true, "result" => $request_priority);
				} else {
					$response = array("status" => false, "type" => "error", "message" => "No se pudo leer el registro.");
				}
			} else {
				$response = array("status" => false, "type" => "error", "message" => "No se enviaron datos.");
			}
			echo json_encode($response, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function insert_priority() 
		{
			if ($_SESSION['status_active_user'] === 0) {
				$response = array("status" => false, "type" => "error", "message" => "Tu cuenta de usuario no está activa.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			check_permissions(MODULE_PRIORITY_MANAGEMENT);
			if (!$_SESSION['module_permissions']['w_write_permission']) {
				$response = array("status" => false, "type" => "error", "message" => "No tienes permisos para registrar nueva prioridad.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			if (!empty($_POST)) {
				if (empty($_POST['name_priority'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, ingrese el nombre de prioridad.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				$str_name_priority = trim($_POST['name_priority']);
				$request_priority = $this->model->insert_priority($str_name_priority);
				if ($request_priority) {
					$response = array("status" => true, "type" => "success", "message" => "Registrado correctamente.");
				} else {
					$response = array("status" => false, "type" => "error", "message" => "No se pudo registrar nueva prioridad.");
				}
			} else {
				$response = array("status" => false, "type" => "error", "message" => "No se enviaron datos.");
			}
			echo json_encode($response, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function update_priority() 
		{
			if ($_SESSION['status_active_user'] === 0) {
				$response = array("status" => false, "type" => "error", "message" => "Tu cuenta de usuario no está activa.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			check_permissions(MODULE_PRIORITY_MANAGEMENT);
			if (!$_SESSION['module_permissions']['u_update_permission']) {
				$response = array("status" => false, "type" => "error", "message" => "No tienes permisos para actualizar el registro.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			if (!empty($_POST)) {
				if (empty($_POST['id_priority'])) {
					$response = array("status" => false, "type" => "error", "message" => "Ocurrió un error, por favor, reinicia el navegador.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if (empty($_POST['name_priority'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, ingrese el nombre de prioridad.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				$int_id_priority = trim($_POST['id_priority']);
				$str_name_priority = trim($_POST['name_priority']);
				$request_priority = $this->model->update_priority($int_id_priority, $str_name_priority);
				if ($request_priority) {
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

		public function delete_priority() 
		{
			if ($_SESSION['status_active_user'] === 0) {
				$response = array("status" => false, "type" => "error", "message" => "Tu cuenta de usuario no está activa.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			check_permissions(MODULE_PRIORITY_MANAGEMENT);
			if (!$_SESSION['module_permissions']['d_delete_permission']) {
				$response = array("status" => false, "type" => "error", "message" => "No tienes permisos para eliminar el registro.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			if (!empty($_POST)) {
				if (empty($_POST['id_priority'])) {
					$response = array("status" => false, "type" => "error", "message" => "Ocurrió un error, por favor, reinicia el navegador.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				$int_id_priority = trim($_POST['id_priority']);
				$request_priority = $this->model->delete_priority($int_id_priority);
				if ($request_priority) {
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

		public function combo(){
			$arrData = $this->model->combo_priorities();
			$html="";
			$html.="<option selected disabled value=''>Selecciona una opción</option>";
			if(is_array($arrData)==true and count($arrData)>0){
				foreach($arrData as $row)
				{
					$html.= "<option value='".$row['id_priority']."'>".$row['name_priority']."</option>";
				}
				echo $html;
			}			
		}

	}
?>