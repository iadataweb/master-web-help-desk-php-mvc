<?php
class Mysql extends Connection {
	private $conexion;
	private $strquery;
	private $arrValues;

	function __construct()
	{
		$this->conexion = new Connection();
		$this->conexion = $this->conexion->conect();
	}

	// Insertar un registro
	public function insert(string $query, array $arrValues)
	{
		$this->strquery = $query;
		$this->arrValues = $arrValues;
		$insert = $this->conexion->prepare($this->strquery);
		$resInsert = $insert->execute($this->arrValues);
		if ($resInsert) {
			$lastInsert = $this->conexion->lastInsertId();
		} else {
			$lastInsert = 0;
		}
		return $lastInsert;
	}

	// Busca un registro (con soporte para consultas parametrizadas)
	public function select(string $query, array $arrValues = [])
	{
		$this->strquery = $query;
		$this->arrValues = $arrValues;
		$result = $this->conexion->prepare($this->strquery);
		$result->execute($this->arrValues); // Pasar los valores aquí
		$data = $result->fetch(PDO::FETCH_ASSOC);
		return $data;
	}

	// Devuelve todos los registros (con soporte para consultas parametrizadas)
	public function select_all(string $query, array $arrValues = [])
	{
		$this->strquery = $query;
		$this->arrValues = $arrValues;
		$result = $this->conexion->prepare($this->strquery);
		$result->execute($this->arrValues); // Pasar los valores aquí
		$data = $result->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	}

	// Actualiza registros (con soporte para consultas parametrizadas)
	public function update(string $query, array $arrValues = [])
	{
		$this->strquery = $query;
		$this->arrValues = $arrValues;
		$update = $this->conexion->prepare($this->strquery);
		$resExecute = $update->execute($this->arrValues); // Pasar los valores aquí
		return $resExecute;
	}

	// Eliminar un registro (con soporte para consultas parametrizadas)
	public function delete(string $query, array $arrValues = [])
	{
		$this->strquery = $query;
		$this->arrValues = $arrValues;
		$result = $this->conexion->prepare($this->strquery);
		$del = $result->execute($this->arrValues); // Pasar los valores aquí
		return $del;
	}
}
?>