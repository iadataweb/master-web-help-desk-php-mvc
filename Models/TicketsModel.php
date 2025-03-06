<?php 
	class TicketsModel extends Mysql
	{
		private $int_id_user;
		private $int_id_support_assigned_ticket;
		private $int_id_ticket;
		private $int_id_attachment_ticket;
		private $str_message;
		private $str_title;
		private $int_id_category;
		private $int_id_subcategory;
		private $int_id_priority;
		private $str_description;
		private $int_status_deleted_ticket;

		public function __construct()
		{
			parent::__construct();
		}

		public function insert_new_ticket(int $id_user, string $title, int $category, int $subcategory, int $priority, string $description){
			$this->int_id_user = $id_user;
			$this->str_title = $title;
			$this->int_id_category = $category;
			$this->int_id_subcategory = $subcategory;
			$this->int_id_priority = $priority ;
			$this->str_description = $description;
			$query_insert = "INSERT INTO tickets(id_user_ticket, id_category_ticket, id_subcategory_ticket, id_priority_ticket, title_ticket, description_ticket) VALUES(?,?,?,?,?,?)";
			$data = [
				$this->int_id_user,
				$this->int_id_category,
				$this->int_id_subcategory,
				$this->int_id_priority,
				$this->str_title,
				$this->str_description
			];
			$request_insert = $this->insert($query_insert, $data);
	        $return = $request_insert;
	        return $return;
		}

		public function update_ticket(int $id_ticket, int $id_user, string $title, int $category, int $subcategory, int $priority, string $description){
			$this->int_id_ticket = $id_ticket;
			$this->int_id_user = $id_user;
			$this->str_title = $title;
			$this->int_id_category = $category;
			$this->int_id_subcategory = $subcategory;
			$this->int_id_priority = $priority ;
			$this->str_description = $description;
			$sql = "UPDATE tickets SET 
					id_user_ticket = ?, 
					id_category_ticket = ?, 
					id_subcategory_ticket = ?, 
					id_priority_ticket = ?, 
					title_ticket = ?,
					description_ticket = ? WHERE id_ticket = ?";
			$data = [
				$this->int_id_user,
				$this->int_id_category,
				$this->int_id_subcategory,
				$this->int_id_priority,
				$this->str_title,
				$this->str_description,
				$this->int_id_ticket
			];
			$request = $this->update($sql, $data);
			$return = $request;
	        return $return;
		}

		public function delete_attachment_ticket(int $id_attachment_ticket){
			$this->int_id_attachment_ticket = $id_attachment_ticket;
			$query  = "DELETE FROM attachments_ticket WHERE id_attachment_ticket = ?";
			$data = [
				$this->int_id_attachment_ticket
			];
	        $request = $this->delete($query, $data);
	        return $request;
		}

		public function insert_attachment_ticket(int $id_ticket, string $file_path, string $file_name) {
			$query_insert = "INSERT INTO attachments_ticket(id_ticket_attachment_ticket, route_attachment_ticket, name_attachment_ticket) VALUES(?, ?, ?)";
			$data = [
				$id_ticket,
                $file_path,
				$file_name
			];
            $request_insert = $this->insert($query_insert, $data);
            return $request_insert;
        }
		
		public function select_all_my_tickets(int $id_user){
			$this->int_id_user = $id_user;
			$sql = "SELECT 	t.id_ticket,
							c.name_category,
							t.title_ticket,
							p.name_priority,
							t.status_open_ticket,
							DATE_FORMAT(t.date_created_ticket, '%d-%m-%Y') AS date_created_ticket,
							t.date_assigned_ticket,
							t.date_closed_ticket,
							t.id_support_assigned_ticket,
							u.first_names_user
					FROM tickets t 
					INNER JOIN categories c ON t.id_category_ticket = c.id_category
					INNER JOIN priorities p ON t.id_priority_ticket = p.id_priority
					LEFT JOIN users u ON t.id_support_assigned_ticket = u.id_user
					WHERE t.id_user_ticket = ? AND t.status_active_ticket = 1 AND t.status_deleted_ticket = 0 ";
			$data = [
				$this->int_id_user
			];
			$request = $this->select_all($sql, $data);
			return $request;
		}

		public function select_tickets_by_support(int $id_user){
			$this->int_id_user = $id_user;
			$sql = "SELECT 	t.id_ticket,
							c.name_category,
							t.title_ticket,
							p.name_priority,
							t.status_open_ticket,
							DATE_FORMAT(t.date_created_ticket, '%d-%m-%Y') AS date_created_ticket,
							t.date_assigned_ticket,
							t.date_closed_ticket,
							t.id_support_assigned_ticket,
							u.first_names_user
					FROM tickets t 
					INNER JOIN categories c ON t.id_category_ticket = c.id_category
					INNER JOIN priorities p ON t.id_priority_ticket = p.id_priority
					LEFT JOIN users u ON t.id_support_assigned_ticket = u.id_user
					WHERE t.id_support_assigned_ticket = ? AND t.status_active_ticket = 1 AND t.status_deleted_ticket = 0";
			$data = [
				$this->int_id_user
			];
			$request = $this->select_all($sql);
			return $request;
		}

		public function select_all_tickets(){
			$sql = "SELECT 	t.id_ticket,
							c.name_category,
							t.title_ticket,
							p.name_priority,
							t.status_open_ticket,
							DATE_FORMAT(t.date_created_ticket, '%d-%m-%Y') AS date_created_ticket,
							t.date_assigned_ticket,
							t.date_closed_ticket,
							t.id_support_assigned_ticket,
							u.first_names_user
					FROM tickets t 
					INNER JOIN categories c ON t.id_category_ticket = c.id_category
					INNER JOIN priorities p ON t.id_priority_ticket = p.id_priority
					LEFT JOIN users u ON t.id_support_assigned_ticket = u.id_user
					WHERE t.status_active_ticket != 0 AND t.status_deleted_ticket = 0";
			$request = $this->select_all($sql);
			return $request;
		}

		public function show_specific_ticket(int $id_ticket){
			$this->int_id_ticket = $id_ticket;
			$sql = "SELECT 	t.id_ticket,
							t.id_user_ticket,
							t.id_support_assigned_ticket,
							u.first_names_user,
							u.email_user,
							su.first_names_user AS support_name,
							t.title_ticket,
							c.id_category,
							c.name_category,
							s.id_subcategory,
							s.name_subcategory,
							p.id_priority,
							p.name_priority,
							t.description_ticket,
							t.status_open_ticket,
							t.date_created_ticket
					FROM tickets t 
					INNER JOIN categories c ON t.id_category_ticket = c.id_category
					INNER JOIN subcategories s ON t.id_subcategory_ticket = s.id_subcategory
					INNER JOIN priorities p ON t.id_priority_ticket = p.id_priority
					LEFT JOIN users u ON t.id_user_ticket = u.id_user
					LEFT JOIN users su ON t.id_support_assigned_ticket = su.id_user
					WHERE t.id_ticket = ?";
			$data = [
				$this->int_id_ticket
			];
			$request = $this->select($sql, $data);
			return $request;
		}

		public function show_attachments_ticket(int $id_ticket){
			$this->int_id_ticket = $id_ticket;
			$sql = "SELECT 	a.id_attachment_ticket, 
							a.id_ticket_attachment_ticket,
							a.route_attachment_ticket,
							a.name_attachment_ticket
					FROM attachments_ticket a 
					INNER JOIN tickets t ON a.id_ticket_attachment_ticket = t.id_ticket
					WHERE a.id_ticket_attachment_ticket = ?";
			$data = [
				$this->int_id_ticket
			];
			$request = $this->select_all($sql, $data);
			return $request;
		}

		public function insert_new_message(int $id_ticket, int $id_user, string $message){
			$this->int_id_ticket = $id_ticket;
			$this->int_id_user = $id_user;
			$this->str_message= $message;
			$query_insert = "INSERT INTO messages(id_ticket_message, id_user_message, content_message) VALUES(?,?,?)";
			$data = [
				$this->int_id_ticket,
				$this->int_id_user,
				$this->str_message
			];
			$request_insert = $this->insert($query_insert, $data);
	        $return = $request_insert;
	        return $return;
		}

		public function insert_attachment_message(int $id_message, string $file_path, string $file_name) {
			$query_insert = "INSERT INTO attachments_message(id_message_attachment_message, route_attachment_message, name_attachment_message) VALUES(?,?,?)";
			$data = [
				$id_message,
                $file_path,
				$file_name
			];
            $request_insert = $this->insert($query_insert, $data);
            return $request_insert;
        }

		public function show_messages(int $id_ticket){
			$this->int_id_ticket = $id_ticket;
			$sql = "SELECT 	m.id_message,
							u.first_names_user,
							m.content_message,
							m.date_created_message
					FROM messages m 
					INNER JOIN users u ON m.id_user_message = u.id_user
					WHERE m.id_ticket_message = ?";
			$data = [
				$this->int_id_ticket
			];
			$request = $this->select_all($sql, $data);
			return $request;
		}

		public function show_attachments_message(int $id_ticket){
			$this->int_id_ticket = $id_ticket;
			$sql = "SELECT 	a.id_message_attachment_message,
							a.route_attachment_message,
							a.name_attachment_message
					FROM attachments_message a 
					INNER JOIN messages m ON a.id_message_attachment_message = m.id_message
					WHERE m.id_ticket_message = ?";
			$data = [
				$this->int_id_ticket
			];
			$request = $this->select_all($sql, $data);
			return $request;
		}

		public function show_support(){
			$sql = "SELECT 	u.id_user, 
							u.first_names_user, 
							u.last_names_user 
					FROM users u
					INNER JOIN additional_permissions ap ON u.id_role_user = ap.id_role_additional_permission
					WHERE u.status_active_user = 1 
					AND u.status_deleted_user = 0 
					AND ap.id_control_additional_permission = 2
					AND ap.allow_additional_permission = 1";
			$request = $this->select_all($sql);
			return $request;
		}

		public function update_support(int $id_ticket, int $id_support_assigned_ticket){
			$this->int_id_ticket = $id_ticket;
			$this->int_id_support_assigned_ticket = $id_support_assigned_ticket;
			$sql = "UPDATE tickets SET id_support_assigned_ticket = ?, date_assigned_ticket = NOW() WHERE id_ticket = ?";
			$data = [
				$this->int_id_support_assigned_ticket,
				$this->int_id_ticket
			];
			$request = $this->update($sql, $data);
			$return = $request;
	        return $return;
		}

		public function close_ticket(int $id_ticket){
			$this->int_id_ticket = $id_ticket;
			$sql = "UPDATE tickets SET status_open_ticket = ?, date_closed_ticket = NOW() WHERE id_ticket = $this->int_id_ticket";
			$data = [
				0
			];
			$request = $this->update($sql, $data);
			$return = $request;
	        return $return;
		}

		public function reopen_ticket(int $id_ticket){
			$this->int_id_ticket = $id_ticket;
			$sql = "UPDATE tickets SET status_open_ticket = ?, date_closed_ticket = NULL WHERE id_ticket = $this->int_id_ticket";
			$data = [
				1
			];
			$request = $this->update($sql, $data);
			$return = $request;
	        return $return;
		}

		public function delete_ticket(int $id_ticket){
			$this->int_id_ticket = $id_ticket;
			$this->int_status_deleted_ticket = 1;
			$sql = "UPDATE tickets SET status_deleted_ticket = ? WHERE id_ticket = ?";
			$data = [
				$this->int_status_deleted_ticket,
				$this->int_id_ticket
			];
			$request = $this->update($sql, $data);
			$return = $request;
	        return $return;
		}

	}
?>