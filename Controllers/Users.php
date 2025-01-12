<?php 

	class Users extends Controllers{
		
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

        public function manage_users()
		{
			if ($_SESSION['status_active_user'] === 0) {
				header("Location: " . base_url() . "/account/logout");
				die();
			}
			check_permissions(MODULE_USER_MANAGEMENT);
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
			$data['page_functions_js'] = "functions_manage_users.js";
			$this->views->getView($this, "manage", $data);
		}

		public function show_users()
		{
            if ($_SESSION['status_active_user'] === 0) {
				header("Location: " . base_url() . "/account/logout");
				die();
			}
			check_permissions(MODULE_USER_MANAGEMENT);
			if(empty($_SESSION['module_permissions']['r_read_permission'])){
				header("Location: " . base_url() . "/errors/forbidden");
				die();
			}
			$data = $this->model->show_users();
			for ($i=0; $i < count($data); $i++) {
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				if($data[$i]['status_active_user'] == 1){
					$data[$i]['status_active_user'] = '<span class="badge bg-success">Activo</span>';
				}else{
					$data[$i]['status_active_user'] = '<span class="badge bg-danger">Inactivo</span>';
				}
				if($_SESSION['module_permissions']['r_read_permission']){
					$btnView = '<button type="button" class="btn icon btn-secondary js-btn-view" data-id="'.$data[$i]['id_user'].'" title="Ver"><i class="bi bi-eye-fill"></i></button>';
				}
				if($_SESSION['module_permissions']['u_update_permission']){
					$btnEdit = '<button type="button" class="btn icon btn-primary js-btn-edit" data-id="'.$data[$i]['id_user'].'" title="Editar"><i class="bi bi-pencil"></i></button>';
				}
				if($_SESSION['module_permissions']['d_delete_permission']){	
					$btnDelete = '<button type="button" class="btn icon btn-danger js-btn-delete" data-id="'.$data[$i]['id_user'].'" title="Eliminar"><i class="bi bi-trash3-fill"></i></button>';
				}
				$data[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
			}
			echo json_encode($data, JSON_UNESCAPED_UNICODE);
		}

		public function show_user() {
			if ($_SESSION['status_active_user'] === 0) {
				$response = array("status" => false, "type" => "error", "message" => "Tu cuenta de usuario no está activa.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
            check_permissions(MODULE_USER_MANAGEMENT);
			if (!$_SESSION['module_permissions']['r_read_permission']) {
				$response = array("status" => false, "type" => "error", "message" => "No tienes permisos para leer el registro.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			if (!empty($_POST)) {
				if (empty($_POST['id_user'])) {
					$response = array("status" => false, "type" => "error", "message" => "Ocurrió un error, por favor, reinicia el navegador.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				$int_id_user = trim($_POST['id_user']);
				$request_user = $this->model->show_user($int_id_user);
				if ($request_user) {
					$response = array("status" => true, "result" => $request_user);
				} else {
					$response = array("status" => false, "type" => "error", "message" => "No se pudo leer el registro.");
				}
			} else {
				$response = array("status" => false, "type" => "error", "message" => "No se enviaron datos.");
			}
			echo json_encode($response, JSON_UNESCAPED_UNICODE);
			die();
		}
		
		public function insert_user() {
            if ($_SESSION['status_active_user'] === 0) {
				$response = array("status" => false, "type" => "error", "message" => "Tu cuenta de usuario no está activa.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			check_permissions(MODULE_USER_MANAGEMENT);
			if (!$_SESSION['module_permissions']['w_write_permission']) {
				$response = array("status" => false, "type" => "error", "message" => "No tienes permisos para registrar nuevo usuario.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			if (!empty($_POST)) {                
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
				if (empty($_POST['password_user'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, ingrese la contraseña.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if (empty($_POST['id_role_user'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, seleccione una opción de rol.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if ($_POST['id_role_user'] == ROLE_SUPER_ADMINISTRATOR) {
					$response = array("status" => false, "type" => "error", "message" => "No se puede asignar el rol de super administrador a otro usuario. Este rol está reservado para el administrador principal del sistema.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if (!isset($_POST['status_active_user'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, seleccione una opción de estado.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				$str_first_names_user = trim($_POST['first_names_user']);
                $str_last_names_user = trim($_POST['last_names_user']);
                $str_cell_phone_user = trim($_POST['cell_phone_user']);
                $str_email_user = trim($_POST['email_user']);
                $str_password_user = password_hash(trim($_POST['password_user']), PASSWORD_DEFAULT);
                $int_id_role_user = trim($_POST['id_role_user']);
                $int_status_active_user = trim($_POST['status_active_user']);
				$email_exists = $this->model->check_email_exists($str_email_user);
				if ($email_exists) {
					$response = array("status" => false, "type" => "error", "message" => "El correo electrónico ya está registrado.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				$request_user = $this->model->insert_user(
                    $str_first_names_user, 
                    $str_last_names_user, 
                    $str_cell_phone_user, 
                    $str_email_user, 
                    $str_password_user, 
                    $int_id_role_user, 
                    $int_status_active_user
                );
				if ($request_user) {
					$response = array("status" => true, "type" => "success", "message" => "Registrado correctamente.");
				} else {
					$response = array("status" => false, "type" => "error", "message" => "No se pudo registrar nuevo usuario.");
				}
			} else {
				$response = array("status" => false, "type" => "error", "message" => "No se enviaron datos.");
			}
			echo json_encode($response, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function update_user() {
			if ($_SESSION['status_active_user'] === 0) {
				$response = array("status" => false, "type" => "error", "message" => "Tu cuenta de usuario no está activa.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
            check_permissions(MODULE_USER_MANAGEMENT);
			if (!$_SESSION['module_permissions']['u_update_permission']) {
				$response = array("status" => false, "type" => "error", "message" => "No tienes permisos para actualizar el registro.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			if (!empty($_POST)) {
				if (empty($_POST['id_user'])) {
					$response = array("status" => false, "type" => "error", "message" => "Ocurrió un error, por favor, reinicia el navegador.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if ($_POST['id_user'] == USER_SUPER_ADMINISTRATOR) {
					$response = array("status" => false, "type" => "error", "message" => "No se puede editar al super administrador del sistema.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
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
				if (empty($_POST['id_role_user'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, seleccione una opción de rol.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if (!isset($_POST['status_active_user'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, seleccione una opción de estado.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				$int_id_user = trim($_POST['id_user']);
                $str_first_names_user = trim($_POST['first_names_user']);
                $str_last_names_user = trim($_POST['last_names_user']);
                $str_cell_phone_user = trim($_POST['cell_phone_user']);
                $str_email_user = trim($_POST['email_user']);
				if ($_POST['password_user'] != "") {
					$str_password_user = password_hash(trim($_POST['password_user']), PASSWORD_DEFAULT);
				} else {
					$str_password_user = "";
				}
                $int_id_role_user = trim($_POST['id_role_user']);
                $int_status_active_user = trim($_POST['status_active_user']);
                $request_user = $this->model->update_user(
                    $int_id_user, 
                    $str_first_names_user, 
                    $str_last_names_user, 
                    $str_cell_phone_user, 
                    $str_email_user, 
                    $str_password_user, 
                    $int_id_role_user, 
                    $int_status_active_user
                );
				if ($request_user) {
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

		public function delete_user() {
			if ($_SESSION['status_active_user'] === 0) {
				$response = array("status" => false, "type" => "error", "message" => "Tu cuenta de usuario no está activa.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
            check_permissions(MODULE_USER_MANAGEMENT);
			if (!$_SESSION['module_permissions']['d_delete_permission']) {
				$response = array("status" => false, "type" => "error", "message" => "No tienes permisos para eliminar el registro.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			if (!empty($_POST)) {
				if (empty($_POST['id_user'])) {
					$response = array("status" => false, "type" => "error", "message" => "Ocurrió un error, por favor, reinicia el navegador.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if ($_POST['id_user'] == USER_SUPER_ADMINISTRATOR) {
					$response = array("status" => false, "type" => "error", "message" => "No se puede eliminar al super administrador del sistema.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				$int_id_user = trim($_POST['id_user']);
				$request_user = $this->model->delete_user($int_id_user);
				if ($request_user) {
					$response = array("status" => true, "type" => "success", "message" => "Eliminado correctamente...");
				} else {
					$response = array("status" => false, "type" => "error", "message" => "No se pudo eliminar el registro.");
				}
			} else {
				$response = array("status" => false, "type" => "error", "message" => "No se enviaron datos.");
			}
			echo json_encode($response, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function show_end_users(){
			$data = $this->model->show_end_users();
			$html="";
			$html.="<option selected disabled value=''>Selecciona una opción</option>";
			if(is_array($data)==true and count($data)>0){
				foreach($data as $row)
				{
					$html.= "<option value='".$row['id_user']."'>".$row['first_names_user'].' '.$row['last_names_user']."</option>";
				}
				echo $html;
			}
		}

	}
?>