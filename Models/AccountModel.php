<?php 
	class AccountModel extends Mysql
	{
		private $int_id_user;
		private $str_first_names_user;
		private $str_last_names_user;
		private $str_email_user;
		private $int_cell_phone_user;

		private $str_current_password;
		private $str_hashed_password;

		public function __construct()
		{
			parent::__construct();
		}

		public function update_personal_data(int $id_user, string $first_names_user, string $last_names_user, string $email_user, int $cell_phone_user)
		{
			$this->int_id_user = $id_user;
			$this->str_first_names_user = $first_names_user;
			$this->str_last_names_user = $last_names_user;
			$this->str_email_user = $email_user;
			$this->int_cell_phone_user = $cell_phone_user;

			$sql = "UPDATE users SET first_names_user = ?, last_names_user = ?, cell_phone_user = ?, email_user = ? WHERE id_user = $this->int_id_user";

			$data = array(
				$this->str_first_names_user,
				$this->str_last_names_user,
				$this->int_cell_phone_user,
				$this->str_email_user);
			
			$request = $this->update($sql, $data);

			return $request;
		}

		public function validate_password(int $id_user, string $current_password)
		{
			$this->int_id_user = $id_user;
			$this->str_current_password = $current_password;

			$sql = "SELECT id_user, password_user FROM users WHERE id_user = $this->int_id_user";
			$request = $this->select($sql);

			if (!password_verify($current_password, $request['password_user'])) {
				$request = false;
			}

			return $request;
		}

		public function update_password(int $id_user, string $hashed_password)
		{
			$this->int_id_user = $id_user;
			$this->str_hashed_password = $hashed_password;

			$sql = "UPDATE users SET password_user = ? WHERE id_user = $this->int_id_user";

			$data = array(
				$this->str_hashed_password);
			
			$request = $this->update($sql, $data);

			return $request;
		}

	}
?>