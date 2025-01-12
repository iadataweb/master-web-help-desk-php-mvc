<?php 

	class Tickets extends Controllers {
		
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

		public function manage_tickets()
		{
			if ($_SESSION['status_active_user'] === 0) {
				header("Location: " . base_url() . "/account/logout");
				die();
			}
			check_permissions(MODULE_TICKET_MANAGEMENT);
			if(empty($_SESSION['module_permissions']['r_read_permission'])){
				header("Location:".base_url().'/errors/forbidden');
				die();
			}
			$data['script'] = [
				"/js/language_datatable.js", 
				"/js/upload_handler.js", 
				"/extensions/datatables.net/js/jquery.dataTables.min.js",
				"/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js",
				"/static/js/pages/datatables.js"
			];
			$data['page_functions_js'] = "functions_manage_tickets.js";
			$this->views->getView($this, "manage", $data);
		}

		public function new_ticket()
		{
			if ($_SESSION['status_active_user'] === 0) {
				header("Location: " . base_url() . "/account/logout");
				die();
			}
			if ($_SESSION['user_data']['id_role'] != ROLE_END_USER) {
				header("Location:".base_url().'/errors/forbidden');
				die();
			}
			$data['script'] = [
				"/extensions/jquery/jquery.min.js",
				"/extensions/parsleyjs/parsley.min.js",
				"/static/js/pages/parsley.js",
				"/js/upload_handler.js"
			];
			$data['page_functions_js'] = "functions_new_ticket.js";
			$this->views->getView($this, "new", $data);
		}

        public function list_of_tickets()
		{
			if ($_SESSION['status_active_user'] === 0) {
				header("Location: " . base_url() . "/account/logout");
				die();
			}
			if ($_SESSION['user_data']['id_role'] != ROLE_END_USER) {
				header("Location:".base_url().'/errors/forbidden');
				die();
			}
			$data['script'] = [
				"/js/language_datatable.js", 
				"/extensions/datatables.net/js/jquery.dataTables.min.js",
				"/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js",
				"/static/js/pages/datatables.js"
			];
			$data['page_functions_js'] = "functions_list_of_tickets.js";
			$this->views->getView($this, "list", $data);
		}

		public function ticket_details($id_ticket)
		{
			if ($_SESSION['status_active_user'] === 0) {
				header("Location: " . base_url() . "/account/logout");
				die();
			}
			$request_specific_ticket = $this->model->show_specific_ticket($id_ticket);
			if ($_SESSION['user_data']['id_role'] != ROLE_END_USER) {
				check_permissions(MODULE_TICKET_MANAGEMENT);
				if(empty($_SESSION['module_permissions']['r_read_permission'])){
					header("Location:".base_url().'/errors/forbidden');
					die();
				}
				check_additional_permissions(MODULE_TICKET_MANAGEMENT);
				if(!empty($_SESSION['additional_permissions_module'][3]['allow_additional_permission'])){
					if ($request_specific_ticket['id_support_assigned_ticket'] != $_SESSION['user_data']['id_user']) {
						header("Location:".base_url().'/errors/forbidden');
						die();
					}
				}				
			}
			if (!$request_specific_ticket) {
				header("Location:".base_url().'/errors/not_found');
				die();
			}

			if ($_SESSION['user_data']['id_role'] == ROLE_END_USER) {
				if ($request_specific_ticket['id_user_ticket'] != $_SESSION['user_data']['id_user']) {
					header("Location:".base_url().'/errors/forbidden');
					die();
				}
			}

			if($request_specific_ticket['status_open_ticket'] == 1) {
				$request_specific_ticket['status_open_ticket'] = '<span id="ticket-status" class="badge bg-success">Ticket Activo</span>';
			} else {
				$request_specific_ticket['status_open_ticket'] = '<span id="ticket-status" class="badge bg-danger">Ticket Cerrado</span>';
			}

			$request_specific_ticket['date_created_ticket'] = date("d/m/Y h:i A", strtotime($request_specific_ticket['date_created_ticket']));

			$data['specific_ticket'] = $request_specific_ticket;
			$data['attachments_ticket'] = $this->model->show_attachments_ticket($id_ticket);
			$data['script'] = [
				"/js/upload_handler.js"
			];
			$data['page_functions_js'] = "functions_ticket_details.js";
			$this->views->getView($this, "details", $data);
		}

		public function show_messages_all()
		{
			if ($_SESSION['status_active_user'] === 0) {
				header("Location: " . base_url() . "/account/logout");
				die();
			}
			$int_id_ticket = trim($_GET['id_ticket']);
			$request_specific_ticket = $this->model->show_specific_ticket($int_id_ticket);
			if ($_SESSION['user_data']['id_role'] != ROLE_END_USER) {
				check_permissions(MODULE_TICKET_MANAGEMENT);
				if(empty($_SESSION['module_permissions']['r_read_permission'])){
					header("Location:".base_url().'/errors/forbidden');
					die();
				}
				check_additional_permissions(MODULE_TICKET_MANAGEMENT);
				if(!empty($_SESSION['additional_permissions_module'][3]['allow_additional_permission'])){
					if ($request_specific_ticket['id_support_assigned_ticket'] != $_SESSION['user_data']['id_user']) {
						header("Location:".base_url().'/errors/forbidden');
						die();
					}
				}				
			}
			if ($_SESSION['user_data']['id_role'] == ROLE_END_USER) {
				if ($request_specific_ticket['id_user_ticket'] != $_SESSION['user_data']['id_user']) {
					header("Location:".base_url().'/errors/forbidden');
					die();
				}
			}
			if (!$request_specific_ticket) {
				header("Location:".base_url().'/errors/not_found');
				die();
			}
			$data['messages'] = $this->model->show_messages($int_id_ticket);
			$data['attachments_message'] = $this->model->show_attachments_message($int_id_ticket);
			$html = generate_html("Tickets", "message-box", $data);
			die();
		}

		public function show_form()
		{
			if ($_SESSION['status_active_user'] === 0) {
				header("Location: " . base_url() . "/account/logout");
				die();
			}
			$int_id_ticket = trim($_GET['id_ticket']);
			$request_specific_ticket = $this->model->show_specific_ticket($int_id_ticket);
			if ($_SESSION['user_data']['id_role'] != ROLE_END_USER) {
				check_permissions(MODULE_TICKET_MANAGEMENT);
				if(empty($_SESSION['module_permissions']['r_read_permission'])){
					header("Location:".base_url().'/errors/forbidden');
					die();
				}
				check_additional_permissions(MODULE_TICKET_MANAGEMENT);
				$data['close_ticket'] = $_SESSION['additional_permissions_module'][8]['allow_additional_permission'];
				$data['reopen_ticket'] = $_SESSION['additional_permissions_module'][9]['allow_additional_permission'];
				if(!empty($_SESSION['additional_permissions_module'][4]['allow_additional_permission'])){
					$data['form_message'] = $request_specific_ticket['id_support_assigned_ticket'] == $_SESSION['user_data']['id_user'];
				} else {
					$data['form_message'] = true;
				}
			}
			if ($_SESSION['user_data']['id_role'] == ROLE_END_USER) {
				if ($request_specific_ticket['id_user_ticket'] != $_SESSION['user_data']['id_user']) {
					header("Location:".base_url().'/errors/forbidden');
					die();
				}
				$data['form_message'] = true;
			}
			$data['specific_ticket'] = $request_specific_ticket;
			$html = generate_html("Tickets", "form", $data);
			die();
		}

		public function show_ticket() {
			if ($_SESSION['status_active_user'] === 0) {
				$response = array("status" => false, "type" => "error", "message" => "Tu cuenta de usuario no está activa.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			check_permissions(MODULE_CATEGORY_MANAGEMENT);
			if (empty($_SESSION['module_permissions']['r_read_permission'])) {
				$response = array("status" => false, "type" => "error", "message" => "No tienes permisos para leer el registro.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			if (!empty($_POST)) {
				if (empty($_POST['id_ticket'])) {
					$response = array("status" => false, "type" => "error", "message" => "Ocurrió un error, por favor, reinicia el navegador.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				$int_id_ticket = trim($_POST['id_ticket']);
				$request_ticket = $this->model->show_specific_ticket($int_id_ticket);
				if ($request_ticket) {
					$request_attachments = $this->model->show_attachments_ticket($int_id_ticket);
					$response = array("status" => true, "result" => $request_ticket, "attachments" => $request_attachments);
				} else {
					$response = array("status" => false, "type" => "error", "message" => "No se pudo leer el registro.");
				}
			} else {
				$response = array("status" => false, "type" => "error", "message" => "No se enviaron datos.");
			}
			echo json_encode($response, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function insert_ticket() {
			if ($_SESSION['status_active_user'] === 0) {
				$response = array("status" => false, "type" => "error", "message" => "Tu cuenta de usuario no está activa.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			if ($_SESSION['user_data']['id_role'] != ROLE_END_USER) {
				check_permissions(MODULE_TICKET_MANAGEMENT);
				if(empty($_SESSION['module_permissions']['w_write_permission'])){
					$response = array("status" => false, "type" => "error", "message" => "No tienes permisos para generar nuevo ticket.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
			}
			if (!empty($_POST)) {
				if (empty($_POST['title'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, ingrese el título.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if (empty($_POST['id_category'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, seleccione una opción de categoría.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if (empty($_POST['id_subcategory'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, seleccione una opción de subcategoría.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if (empty($_POST['id_priority'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, seleccione una opción de prioridad.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if ($_SESSION['user_data']['id_role'] != ROLE_END_USER) {
					if (empty($_POST['id_user'])) {
						$response = array("status" => false, "type" => "error", "message" => "Por favor, seleccione una opción de usuario final.");
						echo json_encode($response, JSON_UNESCAPED_UNICODE);
						return;
					}
					$int_id_user = trim($_POST['id_user']);
				} else {
					$int_id_user = $_SESSION['user_data']['id_user'];
				}
				if (empty($_POST['description'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, ingrese la descripción.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				$str_title = trim($_POST['title']);
				$int_id_category = trim($_POST['id_category']);
				$int_id_subcategory = trim($_POST['id_subcategory']);
				$int_id_priority = trim($_POST['id_priority']);
				$str_description = trim($_POST['description']);

				$files = isset($_FILES['document']) && $_FILES['document']['size'] > 0 ? $_FILES['document'] : null;

				// Verificar la cantidad y el tamaño de los archivos
				if ($files) {
					
					$file_count = count($files['name']);
					$max_file_size = 15 * 1024 * 1024;

					if ($file_count > 5) {
						$response = array("status" => false, "type" => "error", "message" => "Solo se permiten un máximo de 5 archivos.");
						echo json_encode($response, JSON_UNESCAPED_UNICODE);
						return;
					}

					// Verificar cada archivo
					foreach ($files['size'] as $key => $size) {
						if ($size > $max_file_size) {
							$response = array(
								"status" => false,
								"type" => "error",
								"message" => "El archivo '{$files['name'][$key]}' excede el tamaño máximo permitido (15 MB)."
							);
							echo json_encode($response, JSON_UNESCAPED_UNICODE);
							return;
						}
					}

				}

				// Llamar al modelo para insertar el ticket y manejar los archivos
				$request_new_ticket = $this->model->insert_new_ticket($int_id_user, $str_title, $int_id_category, $int_id_subcategory, $int_id_priority, $str_description);
				$id_ticket = $request_new_ticket;

				if ($id_ticket) {
					notify_ticket($id_ticket, "opened");
					// Ahora insertar los archivos asociados al ticket
					if ($files) {
						upload_attachments_ticket($files, $id_ticket);
					}
					$response = array("status" => true, "type" => "success", "message" => "Ticket registrado correctamente: Nro - $id_ticket.");
				} else {
					$response = array("status" => false, "type" => "error", "message" => "No se pudo registrar el ticket.");
				}
			} else {
				$response = array("status" => false, "type" => "error", "message" => "No se enviaron datos.");
			}

			echo json_encode($response, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function update_ticket() {
			if ($_SESSION['status_active_user'] === 0) {
				$response = array("status" => false, "type" => "error", "message" => "Tu cuenta de usuario no está activa.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			check_permissions(MODULE_TICKET_MANAGEMENT);
			if(empty($_SESSION['module_permissions']['u_update_permission'])){
				$response = array("status" => false, "type" => "error", "message" => "No tienes permisos para actualizar el registro.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			if (!empty($_POST)) {
				if (empty($_POST['id_ticket'])) {
					$response = array("status" => false, "type" => "error", "message" => "Ocurrió un error, por favor, reinicia el navegador.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if (empty($_POST['title'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, ingrese el título.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if (empty($_POST['id_category'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, seleccione una opción de categoría.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if (empty($_POST['id_subcategory'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, seleccione una opción de subcategoría.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if (empty($_POST['id_priority'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, seleccione una opción de prioridad.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if (empty($_POST['id_user'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, seleccione una opción de usuario final.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if (empty($_POST['description'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, ingrese la descripción.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				$int_id_ticket = trim($_POST['id_ticket']);
				$int_id_user = trim($_POST['id_user']);
				$str_title = trim($_POST['title']);
				$int_id_category = trim($_POST['id_category']);
				$int_id_subcategory = trim($_POST['id_subcategory']);
				$int_id_priority = trim($_POST['id_priority']);
				$str_description = trim($_POST['description']);
				$files = isset($_FILES['document']) && $_FILES['document']['size'] > 0 ? $_FILES['document'] : null;

				// Verificar la cantidad y el tamaño de los archivos
				if ($files) {
					
					$file_count = count($files['name']);
					$max_file_size = 15 * 1024 * 1024;

					if ($file_count > 5) {
						$response = array("status" => false, "type" => "error", "message" => "Solo se permiten un máximo de 5 archivos.");
						echo json_encode($response, JSON_UNESCAPED_UNICODE);
						return;
					}

					// Verificar cada archivo
					foreach ($files['size'] as $key => $size) {
						if ($size > $max_file_size) {
							$response = array(
								"status" => false,
								"type" => "error",
								"message" => "El archivo '{$files['name'][$key]}' excede el tamaño máximo permitido (15 MB)."
							);
							echo json_encode($response, JSON_UNESCAPED_UNICODE);
							return;
						}
					}

				}

				$request_ticket = $this->model->update_ticket($int_id_ticket, $int_id_user, $str_title, $int_id_category, $int_id_subcategory, $int_id_priority, $str_description);
				if ($request_ticket) {
					if (!empty($_POST['delete_attachments'])) {
						$delete_attachments = $_POST['delete_attachments'];
						$request_attachments_ticket = $this->model->show_attachments_ticket($int_id_ticket);
						$attachments_map = [];
						foreach ($request_attachments_ticket as $item) {
							$attachments_map[$item['id_attachment_ticket']] = $item['route_attachment_ticket'];
						}
						foreach ($delete_attachments as $id) {
							if (isset($attachments_map[$id])) {
								delete_file($attachments_map[$id]);
								$this->model->delete_attachment_ticket($id);
							}
						}
					}
					if ($files) {
						upload_attachments_ticket($files, $int_id_ticket);
					}
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
		
		public function insert_new_message()
		{
			if ($_SESSION['status_active_user'] === 0) {
				$response = array("status" => false, "type" => "error", "message" => "Tu cuenta de usuario no está activa.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			if ($_SESSION['user_data']['id_role'] != ROLE_END_USER) {
				check_additional_permissions(MODULE_TICKET_MANAGEMENT);
				if(!empty($_SESSION['additional_permissions_module'][4]['allow_additional_permission'])){
					$request_specific_ticket = $this->model->show_specific_ticket($_POST['id_ticket']);
					if ($request_specific_ticket['id_support_assigned_ticket'] != $_SESSION['user_data']['id_user']) {
						$response = array("status" => false, "type" => "error", "message" => "No tienes permiso para administrar este ticket. Solo puedes administrar los tickets que te han sido asignados.");
						echo json_encode($response, JSON_UNESCAPED_UNICODE);
						return;
					}
				}
				if(empty($_SESSION['additional_permissions_module'][5]['allow_additional_permission'])){
					$response = array("status" => false, "type" => "error", "message" => "No tienes permisos para enviar mensaje.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
			}
			if (!empty($_POST)) {
				if (empty($_POST['id_ticket'])) {
					$response = array("status" => false, "type" => "error", "message" => "Ocurrió un error, por favor, reinicia el navegador.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if (empty($_POST['message'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, ingrese el mensaje.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				$int_id_user = $_SESSION['user_data']['id_user'];
				$int_id_ticket = trim($_POST['id_ticket']);
				$str_message = trim($_POST['message']);
				$files = isset($_FILES['document']) && $_FILES['document']['size'] > 0 ? $_FILES['document'] : null;

				// Verificar la cantidad y el tamaño de los archivos
				if ($files) {
					
					$file_count = count($files['name']);
					$max_file_size = 15 * 1024 * 1024;

					if ($file_count > 5) {
						$response = array("status" => false, "type" => "error", "message" => "Solo se permiten un máximo de 5 archivos.");
						echo json_encode($response, JSON_UNESCAPED_UNICODE);
						return;
					}

					// Verificar cada archivo
					foreach ($files['size'] as $key => $size) {
						if ($size > $max_file_size) {
							$response = array(
								"status" => false,
								"type" => "error",
								"message" => "El archivo '{$files['name'][$key]}' excede el tamaño máximo permitido (15 MB)."
							);
							echo json_encode($response, JSON_UNESCAPED_UNICODE);
							return;
						}
					}

				}

				// Llamar al modelo para insertar el ticket y manejar los archivos
				$request_new_message = $this->model->insert_new_message($int_id_ticket, $int_id_user, $str_message);
				$id_message = $request_new_message;

				if ($id_message) {
					if ($files) {
						upload_attachments_message($files, $id_message);
					}
					$response = array("status" => true, "type" => "success", "message" => "Mensaje enviado correctamente.");
				} else {
					$response = array("status" => false, "type" => "error", "message" => "No se pudo enviar el mensaje.");
				}
			} else {
				$response = array("status" => false, "type" => "error", "message" => "No se enviaron datos.");
			}
			echo json_encode($response, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function show_tickets()
		{
			if ($_SESSION['status_active_user'] === 0) {
				header("Location: " . base_url() . "/account/logout");
				die();
			}
			if ($_SESSION['user_data']['id_role'] != ROLE_END_USER) {
				check_permissions(MODULE_TICKET_MANAGEMENT);
				if(empty($_SESSION['module_permissions']['r_read_permission'])){
					header("Location:".base_url().'/errors/forbidden');
					die();
				}
				check_additional_permissions(MODULE_TICKET_MANAGEMENT);
				if (empty($_SESSION['additional_permissions_module'][3]['allow_additional_permission'])) {
					$data = $this->model->select_all_tickets();
				} else {
					$data = $this->model->select_tickets_by_support($_SESSION['user_data']['id_user']);
				}
			} else {
				$data = $this->model->select_all_my_tickets($_SESSION['user_data']['id_user']);
			}

			for ($i=0; $i < count($data); $i++) {
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';

				if($data[$i]['status_open_ticket'] == 1) {
					$data[$i]['status_open_ticket'] = '<span class="badge bg-success">Activo</span>';
				} else {
					$data[$i]['status_open_ticket'] = '<span class="badge bg-danger">Cerrado</span>';
				}
				if($data[$i]['date_assigned_ticket'] == null) {
					$data[$i]['date_assigned_ticket'] = '<span class="badge bg-secondary">Sin Asignar</span>';
				}
				if($data[$i]['date_closed_ticket'] == null) {
					$data[$i]['date_closed_ticket'] = '<span class="badge bg-secondary">Sin Cerrar</span>';
				}

				if($data[$i]['id_support_assigned_ticket'] == null) {
					if ($_SESSION['user_data']['id_role'] != ROLE_END_USER) {
						if($_SESSION['additional_permissions_module'][1]['allow_additional_permission']){
							$data[$i]['id_support_assigned_ticket'] = '<span class="btn badge btn-warning js-btn-assign" data-id="'.$data[$i]['id_ticket'].'">Sin Asignar</span>';
						} else {
							$data[$i]['id_support_assigned_ticket'] = '<span class="badge bg-warning">Sin Asignar</span>';
						}
					} else {
						$data[$i]['id_support_assigned_ticket'] = '<span class="badge bg-warning">Sin Asignar</span>';
					}
				} else {
					if ($_SESSION['user_data']['id_role'] != ROLE_END_USER) {
						if($_SESSION['additional_permissions_module'][1]['allow_additional_permission']){
							$data[$i]['id_support_assigned_ticket'] = '<span class="btn badge btn-success js-btn-assign" data-id="'.$data[$i]['id_ticket'].'">'.$data[$i]['first_names_user'].'</span>';
						} else {
							$data[$i]['id_support_assigned_ticket'] = '<span class="badge bg-success">'.$data[$i]['first_names_user'].'</span>';
						}
					} else {
						$data[$i]['id_support_assigned_ticket'] = '<span class="badge bg-success">'.$data[$i]['first_names_user'].'</span>';
					}
				}
				if ($_SESSION['user_data']['id_role'] != ROLE_END_USER) {
					if($_SESSION['module_permissions']['u_update_permission']){
						$btnEdit = '<button type="button" class="btn icon btn-primary js-btn-edit" data-id="'.$data[$i]['id_ticket'].'" title="Editar"><i class="bi bi-pencil"></i></button>';
					}
					if($_SESSION['module_permissions']['d_delete_permission']){	
						$btnDelete = '<button type="button" class="btn icon btn-danger js-btn-delete" data-id="'.$data[$i]['id_ticket'].'" title="Eliminar"><i class="bi bi-trash3-fill"></i></button>';
					}
				}
				$btnDetails = '<span role="button" data-url-details="'.$data[$i]['id_ticket'].'" class="btn icon btn-primary btn-see"><i class="bi bi-eye-fill"></i></span>';

				$data[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnDetails.' '.$btnEdit.' '.$btnDelete.'</div>';
			}
			echo json_encode($data, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function show_support(){
			$data = $this->model->show_support();
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

		public function update_support() {
			if ($_SESSION['status_active_user'] === 0) {
				$response = array("status" => false, "type" => "error", "message" => "Tu cuenta de usuario no está activa.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			check_additional_permissions(MODULE_TICKET_MANAGEMENT);
			if (!$_SESSION['additional_permissions_module'][1]['allow_additional_permission']) {
				$response = array("status" => false, "type" => "error", "message" => "No tienes permisos para asignar soporte al ticket.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			if (!empty($_POST)) {
				if (empty($_POST['id_ticket'])) {
					$response = array("status" => false, "type" => "error", "message" => "Ocurrió un error, por favor, reinicia el navegador.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				if (empty($_POST['id_user'])) {
					$response = array("status" => false, "type" => "error", "message" => "Por favor, seleccione una opción de soporte.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				$int_id_ticket = trim($_POST['id_ticket']);
				$int_id_support_assigned_ticket = trim($_POST['id_user']);
				$request_support = $this->model->update_support($int_id_ticket , $int_id_support_assigned_ticket);
				notify_ticket($int_id_ticket, "assigned");
				if ($request_support) {
					$response = array("status" => true, "type" => "success", "message" => "Asignado correctamente.");
				} else {
					$response = array("status" => false, "type" => "error", "message" => "No se pudo actualizar el registro.");
				}
			} else {
				$response = array("status" => false, "type" => "error", "message" => "No se enviaron datos.");
			}
			echo json_encode($response, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function close_ticket() {
			if ($_SESSION['status_active_user'] === 0) {
				$response = array("status" => false, "type" => "error", "message" => "Tu cuenta de usuario no está activa.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			if ($_SESSION['user_data']['id_role'] != ROLE_END_USER) {
				check_additional_permissions(MODULE_TICKET_MANAGEMENT);
				if(!empty($_SESSION['additional_permissions_module'][4]['allow_additional_permission'])){
					$request_specific_ticket = $this->model->show_specific_ticket($_POST['id_ticket']);
					if ($request_specific_ticket['id_support_assigned_ticket'] != $_SESSION['user_data']['id_user']) {
						$response = array("status" => false, "type" => "error", "message" => "No tienes permiso para administrar este ticket. Solo puedes administrar los tickets que te han sido asignados.");
						echo json_encode($response, JSON_UNESCAPED_UNICODE);
						return;
					}
				}
				if(empty($_SESSION['additional_permissions_module'][8]['allow_additional_permission'])){
					$response = array("status" => false, "type" => "error", "message" => "No tienes permiso para cerrar el ticket.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
			}
			if (!empty($_POST)) {
				if (empty($_POST['id_ticket'])) {
					$response = array("status" => false, "type" => "error", "message" => "Ocurrió un error, por favor, reinicia el navegador.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				$int_id_ticket = trim($_POST['id_ticket']);
				$request_close_ticket = $this->model->close_ticket($int_id_ticket);
				notify_ticket($int_id_ticket, "closed");
				if ($request_close_ticket) {
					$response = array("status" => true, "type" => "success", "message" => "Ticket cerrado correctamente.");
				} else {
					$response = array("status" => false, "type" => "error", "message" => "No se pudo cerrar el ticket.");
				}
			} else {
				$response = array("status" => false, "type" => "error", "message" => "No se enviaron datos.");
			}
			echo json_encode($response, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function reopen_ticket() {
			if ($_SESSION['status_active_user'] === 0) {
				$response = array("status" => false, "type" => "error", "message" => "Tu cuenta de usuario no está activa.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			if ($_SESSION['user_data']['id_role'] != ROLE_END_USER) {
				check_additional_permissions(MODULE_TICKET_MANAGEMENT);
				if(!empty($_SESSION['additional_permissions_module'][4]['allow_additional_permission'])){
					$request_specific_ticket = $this->model->show_specific_ticket($_POST['id_ticket']);
					if ($request_specific_ticket['id_support_assigned_ticket'] != $_SESSION['user_data']['id_user']) {
						$response = array("status" => false, "type" => "error", "message" => "No tienes permiso para administrar este ticket. Solo puedes administrar los tickets que te han sido asignados.");
						echo json_encode($response, JSON_UNESCAPED_UNICODE);
						return;
					}
				}
				if(empty($_SESSION['additional_permissions_module'][9]['allow_additional_permission'])){
					$response = array("status" => false, "type" => "error", "message" => "No tienes permiso para reabrir el ticket.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
			}
			if (!empty($_POST)) {
				if (empty($_POST['id_ticket'])) {
					$response = array("status" => false, "type" => "error", "message" => "Ocurrió un error, por favor, reinicia el navegador.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				$int_id_ticket = trim($_POST['id_ticket']);
				$request_reopen_ticket = $this->model->reopen_ticket($int_id_ticket);
				notify_ticket($int_id_ticket, "reopened");
				if ($request_reopen_ticket) {
					$response = array("status" => true, "type" => "success", "message" => "Ticket abierto correctamente.");
				} else {
					$response = array("status" => false, "type" => "error", "message" => "No se pudo reabrir el ticket.");
				}
			} else {
				$response = array("status" => false, "type" => "error", "message" => "No se enviaron datos.");
			}
			echo json_encode($response, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function delete_ticket() 
		{
			if ($_SESSION['status_active_user'] === 0) {
				$response = array("status" => false, "type" => "error", "message" => "Tu cuenta de usuario no está activa.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			check_permissions(MODULE_TICKET_MANAGEMENT);
			if (!$_SESSION['module_permissions']['d_delete_permission']) {
				$response = array("status" => false, "type" => "error", "message" => "No tienes permisos para eliminar el registro.");
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
				return;
			}
			if (!empty($_POST)) {
				if (empty($_POST['id_ticket'])) {
					$response = array("status" => false, "type" => "error", "message" => "Ocurrió un error, por favor, reinicia el navegador.");
					echo json_encode($response, JSON_UNESCAPED_UNICODE);
					return;
				}
				$int_id_ticket = trim($_POST['id_ticket']);
				$request_ticket = $this->model->delete_ticket($int_id_ticket);
				if ($request_ticket) {
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
	}
?>