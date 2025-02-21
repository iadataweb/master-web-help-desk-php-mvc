<?php 
	class UsersModel extends Mysql
	{
		private $int_id_user;
		private $str_first_names_user;
		private $str_last_names_user;
		private $str_cell_phone_user;
		private $str_email_user;
		private $str_password_user;
		private $int_id_role_user;
		private $int_status_active_user;

		public function __construct()
		{
			parent::__construct();
		}

		public function show_users()
		{
			$sql = "SELECT u.id_user, u.first_names_user, u.last_names_user, u.cell_phone_user, u.email_user, u.status_active_user, r.name_role
					FROM users u 
					INNER JOIN roles r ON u.id_role_user = r.id_role
					WHERE u.id_user != 1 AND u.status_deleted_user = 0";
			$request = $this->select_all($sql);
			return $request;
		}

		public function show_user(int $id_user)
		{
			$this->int_id_user = $id_user;
			$sql = "SELECT u.first_names_user, u.last_names_user, u.cell_phone_user, u.email_user, u.status_active_user, r.id_role, r.name_role
					FROM users u 
					INNER JOIN roles r ON u.id_role_user = r.id_role
					WHERE u.id_user = ? AND u.status_deleted_user = 0";
			$data = [
				$this->int_id_user
			];
			$request = $this->select($sql, $data);
			return $request;
		}

		public function check_email_exists(string $email_user)
		{
			$this->str_email_user = $email_user;
			$sql = "SELECT * FROM users WHERE email_user = ?";
			$data = [
				$this->str_email_user
			];
			$request = $this->select($sql, $data);
			return $request;
		}

		public function get_user_status(int $id_user)
		{
			$this->int_id_user = $id_user;
			$sql = "SELECT status_active_user 
					FROM users 
					WHERE id_user = ? 
					AND status_deleted_user = 0";
			$data = [
				$this->int_id_user
			];
			$request = $this->select($sql, $data);
			return $request;
		}

		public function insert_user(string $first_names_user, string $last_names_user, string $cell_phone_user, string $email_user, string $password_user, int $id_role_user, int $status_active_user){
			$this->str_first_names_user = $first_names_user; 
			$this->str_last_names_user = $last_names_user;
			$this->str_cell_phone_user = $cell_phone_user;
			$this->str_email_user = $email_user;
			$this->str_password_user = $password_user;
			$this->int_id_role_user = $id_role_user;
			$this->int_status_active_user = $status_active_user;
			$query_insert = "INSERT INTO users(id_role_user, first_names_user, last_names_user, cell_phone_user, email_user, password_user, status_active_user) VALUES(?,?,?,?,?,?,?)";
			$data = [
				$this->int_id_role_user,
				$this->str_first_names_user,
				$this->str_last_names_user,
				$this->str_cell_phone_user,
				$this->str_email_user,
				$this->str_password_user,
				$this->int_status_active_user
			];
			$request_insert = $this->insert($query_insert, $data);
	        $return = $request_insert;
	        return $return;
		}

		public function update_user(int $id_user, string $first_names_user, string $last_names_user, string $cell_phone_user, string $email_user, string $password_user, int $id_role_user, int $status_active_user){
			$this->int_id_user = $id_user;
			$this->str_first_names_user = $first_names_user; 
			$this->str_last_names_user = $last_names_user;
			$this->str_cell_phone_user = $cell_phone_user;
			$this->str_email_user = $email_user;
			$this->str_password_user = $password_user;
			$this->int_id_role_user = $id_role_user;
			$this->int_status_active_user = $status_active_user;
			if ($this->str_password_user  != "") {
				$sql = "UPDATE users 
							SET id_role_user = ?, 
								first_names_user = ?, 
								last_names_user = ?, 
								cell_phone_user = ?, 
								email_user = ?, 
								password_user = ?, 
								status_active_user = ? 
							WHERE id_user = ?";
				$data = [
					$this->int_id_role_user,
					$this->str_first_names_user,
					$this->str_last_names_user,
					$this->str_cell_phone_user,
					$this->str_email_user,
					$this->str_password_user,
					$this->int_status_active_user,
					$this->int_id_user
				];
			} else {
				$sql = "UPDATE users 
							SET id_role_user = ?, 
								first_names_user = ?, 
								last_names_user = ?, 
								cell_phone_user = ?, 
								email_user = ?, 
								status_active_user = ? 
							WHERE id_user = ?";
				$data = [
					$this->int_id_role_user,
					$this->str_first_names_user,
					$this->str_last_names_user,
					$this->str_cell_phone_user,
					$this->str_email_user,
					$this->int_status_active_user,
					$this->int_id_user
				];
			}
			$request = $this->update($sql, $data);
			$return = $request;
	        return $return;
		}

		public function delete_user(int $id_user){
			$this->int_id_user = $id_user;
			$this->status_deleted_user = 1;
			$sql = "UPDATE users SET status_deleted_user = ? WHERE id_user = ?";
			$data = [
				$this->status_deleted_user,
				$this->int_id_user
			];
			$request = $this->update($sql, $data);
			$return = $request;
	        return $return;
		}

		public function show_end_users()
		{
			$sql = "SELECT 	id_user, 
							first_names_user, 
							last_names_user 
					FROM users
					WHERE id_role_user = 4
					AND status_active_user = 1 
					AND status_deleted_user = 0";
			$request = $this->select_all($sql);
			return $request;
		}

	}
?>