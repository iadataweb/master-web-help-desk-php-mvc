<?php 
	class NotificationsModel extends Mysql
	{
		private $int_id_ticket;
		private $int_id_user;
		private $str_message;

		public function __construct()
		{
			parent::__construct();
		}

		public function show_all_my_notifications(int $id_user, int $limit, int $offset) {
			$this->int_id_user = $id_user;
			$sql = "SELECT 	id_ticket_notification, 
							id_user_notification, 
							message_notification, 
							status_read_notification, 
							date_created_notification 
					FROM notifications
					WHERE id_user_notification = $this->int_id_user AND status_active_notification = 1 AND status_deleted_notification = 0 
					ORDER BY id_ticket_notification DESC 
					LIMIT $limit OFFSET $offset";
					$request = $this->select_all($sql);
			return $request;
		}
		
		public function count_user_notifications(int $id_user) {
			$sql = "SELECT COUNT(*) as total 
					FROM notifications
					WHERE id_user_notification = $id_user 
						  AND status_active_notification = 1 
						  AND status_deleted_notification = 0";
			$result = $this->select($sql);
			return $result['total'];
		}		

		public function count_unread_notifications(int $id_user) {
			$this->int_id_user = $id_user;
			$sql = "SELECT COUNT(*) AS unread_count
					FROM notifications
					WHERE id_user_notification = $this->int_id_user
					  AND status_active_notification = 1
					  AND status_deleted_notification = 0
					  AND status_read_notification = 0";
			$request = $this->select($sql);
			return $request['unread_count'];
		}		

		public function show_all_my_unread_notifications(int $id_user) {
			$this->int_id_user = $id_user;
			$sql = "SELECT 	id_ticket_notification, 
							id_user_notification, 
							message_notification, 
							status_read_notification, 
							date_created_notification 
					FROM notifications
					WHERE id_user_notification = $this->int_id_user 
					AND status_active_notification = 1 
					AND status_deleted_notification = 0 
					AND status_read_notification = 0
					ORDER BY id_ticket_notification DESC";
					$request = $this->select_all($sql);
			return $request;
		}

		public function insert_notification(int $id_ticket, int $id_user, string $message) {
			$this->int_id_ticket = $id_ticket;
			$this->int_id_user = $id_user;
			$this->str_message = $message;
			$query_insert = "INSERT INTO notifications(id_ticket_notification, id_user_notification, message_notification) VALUES(?,?,?)";
			$data = array(
				$this->int_id_ticket,
				$this->int_id_user,
				$this->str_message
			);
			$request_insert = $this->insert($query_insert, $data);
	        $return = $request_insert;
	        return $return;
		}

		public function update_notifications_status(int $id_user) {
			$this->int_id_user = $id_user;
			$sql = "UPDATE notifications SET status_read_notification = ? 
					WHERE id_user_notification = $this->int_id_user 
					AND status_read_notification = 0";
			$data = array(1);
			$request = $this->update($sql, $data);
			$return = $request;
	        return $return;
		}
	}
?>