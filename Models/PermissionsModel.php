<?php 

	class PermissionsModel extends Mysql
	{
		public $int_id_role;
		public $int_id_module;
		public $int_r;
		public $int_w;
		public $int_u;
		public $int_d;

		public function __construct()
		{
			parent::__construct();
		}

		public function show_permissions(int $id_role)
		{
			$this->int_id_role = $id_role;
			$sql = "SELECT p.id_permission, p.r_read_permission, p.w_write_permission, p.u_update_permission, p.d_delete_permission, m.id_module, m.name_module
					FROM permissions p
					INNER JOIN modules m ON p.id_module_permission = m.id_module
					WHERE p.id_role_permission = $this->int_id_role";
			$request = $this->select_all($sql);
			return $request;
		}

		public function select_modules()
		{
			$sql = "SELECT id_module, name_module FROM modules";
			$request = $this->select_all($sql);
			return $request;
		}

		public function check_permissions(int $id_role)
		{
			$this->int_id_role = $id_role;
			$sql = "SELECT COUNT(*) AS total FROM permissions WHERE id_role_permission = $this->int_id_role";
			$request = $this->select_all($sql);
			return $request;
		}

		public function insert_permission(int $id_role, int $id_module, int $r, int $w, int $u, int $d){
			$this->int_id_role = $id_role;
			$this->int_id_module = $id_module;
			$this->int_r = $r;
			$this->int_w = $w;
			$this->int_u = $u;
			$this->int_d = $d;
			$query_insert = "INSERT INTO permissions(id_role_permission, id_module_permission, r_read_permission, w_write_permission, u_update_permission, d_delete_permission) VALUES(?,?,?,?,?,?)";
			$data = array(
				$this->int_id_role,
				$this->int_id_module,
				$this->int_r,
				$this->int_w,
				$this->int_u,
				$this->int_d
			);
			$request_insert = $this->insert($query_insert, $data);
	        $return = $request_insert;
	        return $return;
		}

		public function update_permission(int $id_role, int $id_module, int $r, int $w, int $u, int $d){
			$this->int_id_role = $id_role;
			$this->int_id_module = $id_module;
			$this->int_r = $r;
			$this->int_w = $w;
			$this->int_u = $u;
			$this->int_d = $d;
			$sql = "UPDATE permissions SET r_read_permission = ?, w_write_permission = ?, u_update_permission = ?, d_delete_permission = ? WHERE id_role_permission = $this->int_id_role AND id_module_permission = $this->int_id_module";
			$data = array(
				$this->int_r,
				$this->int_w,
				$this->int_u,
				$this->int_d
			);
			$request = $this->update($sql, $data);
			$return = $request;
	        return $return;
		}

		public function extract_permissions(int $id_role){
			$this->int_id_role = $id_role;
			$sql = "SELECT p.id_role_permission,
						   p.id_module_permission,
						   m.name_module,
						   p.r_read_permission,
						   p.w_write_permission,
						   p.u_update_permission,
						   p.d_delete_permission 
					FROM permissions p 
					INNER JOIN modules m
					ON p.id_module_permission = m.id_module
					WHERE p.id_role_permission = $this->int_id_role";
			$request = $this->select_all($sql);
			$data_permissions = array();
			for ($i=0; $i < count($request); $i++) { 
				$data_permissions[$request[$i]['id_module_permission']] = $request[$i];
			}
			return $data_permissions;
		}
		
	}
?>