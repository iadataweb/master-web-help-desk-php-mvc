<?php 
	class RolesModel extends Mysql
	{
		private $int_id_role;
		private $str_name_role;
		private $str_description_role;
		private $int_status_active_role;

		public function __construct()
		{
			parent::__construct();
		}

		public function show_roles()
		{
			$sql = "SELECT id_role, name_role, status_active_role FROM roles WHERE status_deleted_role = 0 AND id_role != 1 AND id_role != 4";
			$request = $this->select_all($sql);
			return $request;
		}

		public function show_role(int $id_role)
		{
			$this->int_id_role = $id_role;
			$sql = "SELECT name_role, description_role, status_active_role FROM roles WHERE id_role = $this->int_id_role AND status_deleted_role = 0";
			$request = $this->select($sql);
			return $request;
		}

		public function insert_role(string $name_role, string $description_role, int $status_active_role){
			$this->str_name_role = $name_role;
			$this->str_description_role = $description_role;
			$this->int_status_active_role = $status_active_role;
			$query_insert = "INSERT INTO roles(name_role, description_role, status_active_role) VALUES(?,?,?)";
			$data = array(
				$this->str_name_role,
				$this->str_description_role,
				$this->int_status_active_role
			);
			$request_insert = $this->insert($query_insert, $data);
	        $return = $request_insert;
	        return $return;
		}

		public function update_role(int $id_role, string $name_role, string $description_role, int $status_active_role){
			$this->int_id_role = $id_role;
			$this->str_name_role = $name_role;
			$this->str_description_role = $description_role;
			$this->int_status_active_role = $status_active_role;
			$sql = "UPDATE roles SET name_role = ?, description_role = ?, status_active_role = ? WHERE id_role = $this->int_id_role";
			$data = array(
				$this->str_name_role,
				$this->str_description_role,
				$this->int_status_active_role
			);
			$request = $this->update($sql, $data);
			$return = $request;
	        return $return;
		}

		public function delete_role(int $id_role){
			$this->int_id_role = $id_role;
			$this->int_status_deleted_role = 1;
			$sql = "UPDATE roles SET status_deleted_role = ? WHERE id_role = $this->int_id_role";
			$data = array(
				$this->int_status_deleted_role
			);
			$request = $this->update($sql, $data);
			$return = $request;
	        return $return;
		}

		public function combo_roles()
		{
			$sql = "SELECT id_role, name_role FROM roles WHERE id_role != 1 AND status_active_role = 1 AND status_deleted_role = 0";
			$request = $this->select_all($sql);
			return $request;
		}
	}
?>