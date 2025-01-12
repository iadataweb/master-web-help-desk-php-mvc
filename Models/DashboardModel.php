<?php 
	class DashboardModel extends Mysql
	{
		private $int_id_user;

		public function __construct()
		{
			parent::__construct();
		}

		public function show_total_tickets_generated_global()
		{
			$sql = "SELECT COUNT(*) as total FROM tickets WHERE status_active_ticket = 1 AND status_deleted_ticket = 0";
			$request = $this->select($sql);
			$total = $request['total']; 
			return $total;
		}

		public function show_total_pending_tickets_global()
		{
			$sql = "SELECT COUNT(*) as total FROM tickets WHERE id_support_assigned_ticket IS NULL AND status_open_ticket = 1 AND status_active_ticket = 1 AND status_deleted_ticket = 0";
			$request = $this->select($sql);
			$total = $request['total']; 
			return $total;
		}

		public function show_total_in_progress_tickets_global()
		{
			$sql = "SELECT COUNT(*) as total FROM tickets WHERE id_support_assigned_ticket IS NOT NULL AND status_open_ticket = 1 AND status_active_ticket = 1 AND status_deleted_ticket = 0";
			$request = $this->select($sql);
			$total = $request['total']; 
			return $total;
		}

		public function show_total_closed_tickets_global()
		{
			$sql = "SELECT COUNT(*) as total FROM tickets WHERE status_open_ticket = 0 AND status_active_ticket = 1 AND status_deleted_ticket = 0";
			$request = $this->select($sql);
			$total = $request['total']; 
			return $total;
		}

		public function show_data_categories_global()
		{
			$sql = "SELECT 	c.id_category, 
							c.name_category, 
							COUNT(*) as total 
					FROM categories c 
					INNER JOIN tickets t ON c.id_category = t.id_category_ticket 
					WHERE c.status_active_category = 1 
					AND c.status_deleted_category = 0
					AND t.status_active_ticket = 1 
					AND t.status_deleted_ticket = 0
					GROUP BY c.id_category";
			$request = $this->select_all($sql);
			return $request;
		}

		public function show_total_tickets_generated_user(int $id_user)
		{
			$this->int_id_user = $id_user;
			$sql = "SELECT COUNT(*) as total FROM tickets WHERE id_user_ticket = $this->int_id_user AND status_active_ticket = 1 AND status_deleted_ticket = 0";
			$request = $this->select($sql);
			$total = $request['total']; 
			return $total;
		}

		public function show_total_pending_tickets_user(int $id_user)
		{
			$this->int_id_user = $id_user;
			$sql = "SELECT COUNT(*) as total FROM tickets WHERE id_user_ticket = $this->int_id_user AND id_support_assigned_ticket IS NULL AND status_open_ticket = 1 AND status_active_ticket = 1 AND status_deleted_ticket = 0";
			$request = $this->select($sql);
			$total = $request['total']; 
			return $total;
		}

		public function show_total_in_progress_tickets_user(int $id_user)
		{
			$this->int_id_user = $id_user;
			$sql = "SELECT COUNT(*) as total FROM tickets WHERE id_user_ticket = $this->int_id_user AND id_support_assigned_ticket IS NOT NULL AND status_open_ticket = 1 AND status_active_ticket = 1 AND status_deleted_ticket = 0";
			$request = $this->select($sql);
			$total = $request['total']; 
			return $total;
		}

		public function show_total_closed_tickets_user(int $id_user)
		{
			$this->int_id_user = $id_user;
			$sql = "SELECT COUNT(*) as total FROM tickets WHERE id_user_ticket = $this->int_id_user AND status_open_ticket = 0 AND status_active_ticket = 1 AND status_deleted_ticket = 0";
			$request = $this->select($sql);
			$total = $request['total']; 
			return $total;
		}

		public function show_data_categories_user(int $id_user)
		{
			$this->int_id_user = $id_user;
			$sql = "SELECT 	c.id_category, 
							c.name_category, 
							COUNT(*) as total 
					FROM categories c 
					INNER JOIN tickets t ON c.id_category = t.id_category_ticket 
					WHERE t.id_user_ticket = $this->int_id_user
					AND c.status_active_category = 1 
					AND c.status_deleted_category = 0
					AND t.status_active_ticket = 1 
					AND t.status_deleted_ticket = 0
					GROUP BY c.id_category";
			$request = $this->select_all($sql);
			return $request;
		}
		
	}
?>