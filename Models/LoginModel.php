<?php 

	class LoginModel extends Mysql
	{
		private $int_id_user;
		private $str_email;
		private $str_password;

		public function __construct()
		{
			parent::__construct();
		}	

		public function login_user(string $email, string $password)
		{
			$this->str_email = $email;
			$this->str_password = $password;
			$sql = "SELECT id_user, password_user, status_active_user FROM users WHERE 
					email_user = '$this->str_email'";
			$request = $this->select($sql);
			if (!password_verify($password, $request['password_user'])) {
				$request = false;
			}
			return $request;
		}
		
        public function session_login(int $id_user)
		{
			$this->int_id_user = $id_user;
			$sql = "SELECT  u.id_user,
							u.first_names_user,
							u.last_names_user,
							u.cell_phone_user,
							u.email_user,
							u.status_active_user,
							r.id_role,
							r.name_role
					FROM users u
					INNER JOIN roles r
					ON u.id_role_user = r.id_role
					WHERE u.id_user = $this->int_id_user";
			$request = $this->select($sql);
			return $request;
		}
	}
?>