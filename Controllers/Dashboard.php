<?php 

	class Dashboard extends Controllers{
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

		public function dashboard()
		{
			if ($_SESSION['status_active_user'] === 0) {
				header("Location: " . base_url() . "/account/logout");
				die();
			}
			if ($_SESSION['user_data']['id_role'] != ROLE_END_USER) {
				check_permissions(MODULE_DASHBOARD);
				$data['total_tickets_generated'] = $this->model->show_total_tickets_generated_global();
				$data['total_pending_tickets'] = $this->model->show_total_pending_tickets_global();
				$data['total_in_progress_tickets'] = $this->model->show_total_in_progress_tickets_global();
				$data['total_closed_tickets'] = $this->model->show_total_closed_tickets_global();
			} else {
				$int_id_user = $_SESSION['user_data']['id_user'];
				$data['total_tickets_generated'] = $this->model->show_total_tickets_generated_user($int_id_user);
				$data['total_pending_tickets'] = $this->model->show_total_pending_tickets_user($int_id_user);
				$data['total_in_progress_tickets'] = $this->model->show_total_in_progress_tickets_user($int_id_user);
				$data['total_closed_tickets'] = $this->model->show_total_closed_tickets_user($int_id_user);
			}
			$data['css'] = [
				"/css/iconly.css"
			];
			$data['script'] = [
				"/extensions/apexcharts/apexcharts.min.js"
			];
			$data['page_functions_js'] = "functions_dashboard.js";
            $this->views->getView($this, "index", $data);
		}

		public function show_category_data()
		{
			if ($_SESSION['user_data']['id_role'] != ROLE_END_USER) {
				$request_category_data = $this->model->show_data_categories_global();
			} else {
				$int_id_user = $_SESSION['user_data']['id_user'];
				$request_category_data = $this->model->show_data_categories_user($int_id_user);
			}
			$total = array_sum(array_column($request_category_data, 'total'));
			foreach ($request_category_data as &$category) {
				$category['porcentaje'] = round(($category['total'] / $total) * 100, 1);
			}
			$response = array("result" => $request_category_data);
			echo json_encode($response, JSON_UNESCAPED_UNICODE);
			die();
		}
	}
?>