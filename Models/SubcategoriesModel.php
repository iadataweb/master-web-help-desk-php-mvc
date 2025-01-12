<?php 
	class SubcategoriesModel extends Mysql
	{
        public $intIdcategoria;
		private $int_id_subcategory;
		private $int_id_category;
		private $str_name_subcategory;
		private $int_status_deleted_subcategory;

		public function __construct()
		{
			parent::__construct();
		}

		public function show_subcategories()
		{
			$sql = "SELECT s.id_subcategory, s.name_subcategory, c.name_category 
					FROM subcategories s 
					INNER JOIN categories c ON s.id_category_subcategory = c.id_category
					WHERE s.status_active_subcategory = 1 AND s.status_deleted_subcategory = 0";
			$request = $this->select_all($sql);
			return $request;
		}

		public function show_subcategory(int $id_subcategory)
		{
			$this->int_id_subcategory = $id_subcategory;
			$sql = "SELECT s.id_category_subcategory, s.name_subcategory, c.name_category 
					FROM subcategories s
					INNER JOIN categories c ON s.id_category_subcategory = c.id_category
					WHERE s.id_subcategory = $this->int_id_subcategory AND status_active_subcategory = 1 AND status_deleted_subcategory = 0";
			$request = $this->select($sql);
			return $request;
		}

		public function insert_subcategory(int $id_category, string $name_subcategory){

			$this->int_id_category = $id_category;
			$this->str_name_subcategory = $name_subcategory;
			
			$query_insert = "INSERT INTO subcategories(id_category_subcategory, name_subcategory) VALUES(?,?)";

			$data = array(
				$this->int_id_category,
				$this->str_name_subcategory
			);

			$request_insert = $this->insert($query_insert, $data);
	        $return = $request_insert;

	        return $return;
		}

		public function update_subcategory(int $id_subcategory, int $id_category, string $name_subcategory){
			$this->int_id_subcategory = $id_subcategory;
			$this->int_id_category = $id_category;
			$this->str_name_subcategory = $name_subcategory;
			$sql = "UPDATE subcategories SET id_category_subcategory = ?, name_subcategory = ? WHERE id_subcategory = $this->int_id_subcategory";
			$data = array(
				$this->int_id_category,
				$this->str_name_subcategory
			);
			$request = $this->update($sql, $data);
			$return = $request;
	        return $return;
		}

		public function delete_subcategory(int $id_subcategory){
			$this->int_id_subcategory = $id_subcategory;
			$this->int_status_deleted_subcategory = 1;
			$sql = "UPDATE subcategories SET status_deleted_subcategory = ? WHERE id_subcategory = $this->int_id_subcategory";
			$data = array(
				$this->int_status_deleted_subcategory
			);
			$request = $this->update($sql, $data);
			$return = $request;
	        return $return;
		}

        public function combo_subcategories($idcategoria)
		{
            $this->intIdcategoria = $idcategoria;
			$sql = "SELECT * FROM subcategories WHERE id_category_subcategory = $this->intIdcategoria AND status_active_subcategory != 0 ";
			$request = $this->select_all($sql);
			return $request;
		}
        
	}
?>