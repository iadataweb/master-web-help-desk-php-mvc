<?php 
	class PrioritiesModel extends Mysql
	{
		private $int_id_priority;
		private $str_name_priority;
		private $int_status_deleted_priority;

		public function __construct()
		{
			parent::__construct();
		}

		public function show_priorities()
		{
			$sql = "SELECT id_priority, name_priority FROM priorities WHERE status_active_priority = 1 AND status_deleted_priority = 0";
			$request = $this->select_all($sql);
			return $request;
		}

		public function show_priority(int $id_priority)
		{
			$this->int_id_priority = $id_priority;
			$sql = "SELECT name_priority FROM priorities WHERE id_priority = $this->int_id_priority AND status_active_priority = 1 AND status_deleted_priority = 0";
			$request = $this->select($sql);
			return $request;
		}

		public function insert_priority(string $name_priority){

			$this->str_name_priority = $name_priority;
			
			$query_insert = "INSERT INTO priorities(name_priority) VALUES(?)";

			$data = array(
				$this->str_name_priority);

			$request_insert = $this->insert($query_insert, $data);
	        $return = $request_insert;

	        return $return;
		}

		public function update_priority(int $id_priority, string $name_priority){
			$this->int_id_priority = $id_priority;
			$this->str_name_priority = $name_priority;
			$sql = "UPDATE priorities SET name_priority = ? WHERE id_priority = $this->int_id_priority";
			$data = array(
				$this->str_name_priority
			);
			$request = $this->update($sql, $data);
			$return = $request;
	        return $return;
		}

		public function delete_priority(int $id_priority){
			$this->int_id_priority = $id_priority;
			$this->int_status_deleted_priority = 1;
			$sql = "UPDATE priorities SET status_deleted_priority = ? WHERE id_priority = $this->int_id_priority";
			$data = array(
				$this->int_status_deleted_priority
			);
			$request = $this->update($sql, $data);
			$return = $request;
	        return $return;
		}

        public function combo_priorities()
		{
			$sql = "SELECT id_priority, name_priority FROM priorities WHERE status_active_priority = 1 AND status_deleted_priority = 0";
			$request = $this->select_all($sql);
			return $request;
		}
	}
?>