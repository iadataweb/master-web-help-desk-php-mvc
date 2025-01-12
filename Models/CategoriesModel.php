<?php 
	class CategoriesModel extends Mysql
	{
		private $int_id_category;
		private $str_name_category;
		private $int_status_deleted_category;

		public function __construct()
		{
			parent::__construct();
		}

		public function show_categories()
		{
			$sql = "SELECT id_category, name_category FROM categories WHERE status_active_category = 1 AND status_deleted_category = 0";
			$request = $this->select_all($sql);
			return $request;
		}

		public function show_category(int $id_category)
		{
			$this->int_id_category = $id_category;
			$sql = "SELECT name_category FROM categories WHERE id_category = $this->int_id_category AND status_active_category = 1 AND status_deleted_category = 0";
			$request = $this->select($sql);
			return $request;
		}

		public function insert_category(string $name_category){
			$this->str_name_category = $name_category;
			$query_insert = "INSERT INTO categories(name_category) VALUES(?)";
			$data = array(
				$this->str_name_category
			);
			$request_insert = $this->insert($query_insert, $data);
	        $return = $request_insert;
	        return $return;
		}

		public function update_category(int $id_category, string $name_category){
			$this->int_id_category = $id_category;
			$this->str_name_category = $name_category;
			$sql = "UPDATE categories SET name_category = ? WHERE id_category = $this->int_id_category";
			$data = array(
				$this->str_name_category
			);
			$request = $this->update($sql, $data);
			$return = $request;
	        return $return;
		}

		public function delete_category(int $id_category){
			$this->int_id_category = $id_category;
			$this->int_status_deleted_category = 1;
			$sql = "UPDATE categories SET status_deleted_category = ? WHERE id_category = $this->int_id_category";
			$data = array(
				$this->int_status_deleted_category
			);
			$request = $this->update($sql, $data);
			$return = $request;
	        return $return;
		}

        public function combo_categories()
		{
			$sql = "SELECT id_category, name_category FROM categories WHERE status_active_category = 1 AND status_deleted_category = 0";
			$request = $this->select_all($sql);
			return $request;
		}
	}
?>