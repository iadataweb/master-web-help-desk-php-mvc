<?php 

	class Subcategories extends Controllers{
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

		public function manage_subcategories()
		{
			if ($_SESSION['status_active_user'] === 0) {
				header("Location: " . base_url() . "/account/logout");
				die();
			}
			check_permissions(MODULE_SUBCATEGORY_MANAGEMENT);
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
			$data['page_functions_js'] = "functions_manage_subcategories.js";
			$this->views->getView($this, "manage", $data);
		}
		
		public function show_subcategories()
		{
			if ($_SESSION['status_active_user'] === 0) {
				header("Location: " . base_url() . "/account/logout");
				die();
			}
			check_permissions(MODULE_SUBCATEGORY_MANAGEMENT);
			if(empty($_SESSION['module_permissions']['r_read_permission'])){
				header("Location:".base_url().'/errors/forbidden');
				die();
			}
			$data = $this->model->show_subcategories();
			for ($i=0; $i < count($data); $i++) {
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				if($_SESSION['module_permissions']['r_read_permission']){
					$btnView = '<button type="button" class="btn icon btn-secondary js-btn-view" data-id="'.$data[$i]['id_subcategory'].'" title="Ver"><i class="bi bi-eye-fill"></i></button>';
				}
				if($_SESSION['module_permissions']['u_update_permission']){
					$btnEdit = '<button type="button" class="btn icon btn-primary js-btn-edit" data-id="'.$data[$i]['id_subcategory'].'" title="Editar"><i class="bi bi-pencil"></i></button>';
				}
				if($_SESSION['module_permissions']['d_delete_permission']){	
					$btnDelete = '<button type="button" class="btn icon btn-danger js-btn-delete" data-id="'.$data[$i]['id_subcategory'].'" title="Eliminar"><i class="bi bi-trash3-fill"></i></button>';
				}
				$data[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
			}
			echo json_encode($data, JSON_UNESCAPED_UNICODE);
		}

		public function show_subcategory() 
		{
			if ($_SESSION['status_active_user'] === 0) {
				$response = array("status" => false, "type" => "error", "message" => "Tu cuenta de usuario no está activa.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			check_permissions(MODULE_SUBCATEGORY_MANAGEMENT);
			if (!$_SESSION['module_permissions']['r_read_permission']) {
				$response = array("status" => false, "type" => "error", "message" => "No tienes permisos para leer el registro.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			if (!empty($_POST)) {
				if (empty($_POST['id_subcategory'])) {
					$response = array("status" => false, "type" => "error", "message" => "Ocurrió un error, por favor, reinicia el navegador.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				$int_id_subcategory = trim($_POST['id_subcategory']);
				$request_subcategory = $this->model->show_subcategory($int_id_subcategory);
				if ($request_subcategory) {
					$response = array("status" => true, "result" => $request_subcategory);
				} else {
					$response = array("status" => false, "type" => "error", "message" => "No se pudo leer el registro.");
				}
			} else {
				$response = array("status" => false, "type" => "error", "message" => "No se enviaron datos.");
			}
			echo json_encode($response, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function insert_subcategory() 
		{
			if ($_SESSION['status_active_user'] === 0) {
				$response = array("status" => false, "type" => "error", "message" => "Tu cuenta de usuario no está activa.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			check_permissions(MODULE_SUBCATEGORY_MANAGEMENT);
			if (!$_SESSION['module_permissions']['w_write_permission']) {
				$response = array("status" => false, "type" => "error", "message" => "No tienes permisos para registrar nueva subcategoría.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			if (!empty($_POST)) {
				if (empty($_POST['name_subcategory'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, ingrese el nombre de subcategoría.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if (empty($_POST['id_category'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, seleccione una opción de categoría.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				$str_name_subcategory = trim($_POST['name_subcategory']);
				$int_id_category = trim($_POST['id_category']);
				$request_subcategory = $this->model->insert_subcategory($int_id_category, $str_name_subcategory);
				if ($request_subcategory) {
					$response = array("status" => true, "type" => "success", "message" => "Registrado correctamente.");
				} else {
					$response = array("status" => false, "type" => "error", "message" => "No se pudo registrar nueva categoría.");
				}
			} else {
				$response = array("status" => false, "type" => "error", "message" => "No se enviaron datos.");
			}
			echo json_encode($response, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function update_subcategory() 
		{
			if ($_SESSION['status_active_user'] === 0) {
				$response = array("status" => false, "type" => "error", "message" => "Tu cuenta de usuario no está activa.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			check_permissions(MODULE_SUBCATEGORY_MANAGEMENT);
			if (!$_SESSION['module_permissions']['u_update_permission']) {
				$response = array("status" => false, "type" => "error", "message" => "No tienes permisos para actualizar el registro.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			if (!empty($_POST)) {
				if (empty($_POST['id_subcategory'])) {
					$response = array("status" => false, "type" => "error", "message" => "Ocurrió un error, por favor, reinicia el navegador.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if (empty($_POST['name_subcategory'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, ingrese el nombre de subcategoría.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if (empty($_POST['id_category'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, seleccione una opción de categoría.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				$int_id_subcategory = trim($_POST['id_subcategory']);
				$int_id_category = trim($_POST['id_category']);
				$str_name_subcategory = trim($_POST['name_subcategory']);
				$request_subcategory = $this->model->update_subcategory($int_id_subcategory, $int_id_category, $str_name_subcategory);
				if ($request_subcategory) {
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

		public function delete_subcategory() 
		{
			if ($_SESSION['status_active_user'] === 0) {
				$response = array("status" => false, "type" => "error", "message" => "Tu cuenta de usuario no está activa.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			check_permissions(MODULE_SUBCATEGORY_MANAGEMENT);
			if (!$_SESSION['module_permissions']['d_delete_permission']) {
				$response = array("status" => false, "type" => "error", "message" => "No tienes permisos para eliminar el registro.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			if (!empty($_POST)) {
				if (empty($_POST['id_subcategory'])) {
					$response = array("status" => false, "type" => "error", "message" => "Ocurrió un error, por favor, reinicia el navegador.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				$int_id_subcategory = trim($_POST['id_subcategory']);
				$request_subcategory = $this->model->delete_subcategory($int_id_subcategory);
				if ($request_subcategory) {
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
			$arrData = $this->model->combo_subcategories($_POST["cat_id"]);
			$html="";
			$html.="<option selected disabled value=''>Selecciona una opción</option>";
			if(is_array($arrData)==true and count($arrData)>0){
				foreach($arrData as $row)
				{
					$html.= "<option value='".$row['id_subcategory']."'>".$row['name_subcategory']."</option>";
				}
				echo $html;
			}
			
		}

	}
?>