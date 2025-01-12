<?php 

	class Notifications extends Controllers{
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

		public function notifications()
		{
			if ($_SESSION['status_active_user'] === 0) {
				header("Location: " . base_url() . "/account/logout");
				die();
			}
			
			$int_id_user = $_SESSION['user_data']['id_user'];

			$notifications_per_page = 5;
			$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
			$offset = ($current_page - 1) * $notifications_per_page;

			$total_notifications = $this->model->count_user_notifications($int_id_user);

			$data['notifications'] = $this->model->show_all_my_notifications($int_id_user, $notifications_per_page, $offset);

			$data['total_pages'] = ceil($total_notifications / $notifications_per_page);
			$data['current_page'] = $current_page;
			
			$this->views->getView($this, "index", $data);
		}

		public function show_notification_dropdown()
		{
			$int_id_user = $_SESSION['user_data']['id_user'];
			$data['count_unread_notifications'] = $this->model->count_unread_notifications($int_id_user);
			$data['unread_notifications'] = $this->model->show_all_my_unread_notifications($int_id_user);
			$html = generate_html("Notifications", "dropdown", $data);
			die();
		}

		public function mark_notifications_read() {
			$int_id_user = $_SESSION['user_data']['id_user'];
			$this->model->update_notifications_status($int_id_user);
		}
	}
?>