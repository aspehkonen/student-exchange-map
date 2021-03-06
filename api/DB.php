<?php

class DB {
	var $dbname = 'vaihtosovellus';
	var $db;

	function connect() {
		$this->db = new PDO('mysql:host=localhost;dbname=' . $this->dbname . ';charset=utf8mb4', 'root', '');
	}

	function get($table, $options = []) {
		$query = "SELECT * FROM $table WHERE ";
		
		$i = 0;
		$len = count($options);
		foreach ($options as $key => $option) {
			if ($i < $len - 1) {
				$query .= $key . ' = ' . $this->db->quote($option) . ' AND ';
			} else {
				$query .= $key . ' = ' . $this->db->quote($option);
			}
			$i++;
		}

		$result = $this->db->query($query);

		return $result->fetchAll(PDO::FETCH_ASSOC);
	}

	function update($table, $where = [], $values = []) {
		$query = "UPDATE $table SET ";

		$i = 0;
		$len = count($values);
		foreach ($values as $key => $value) {
			if ($i < $len - 1) {
				$query .= $key . ' = ' . $this->db->quote($value) . ', ';
			} else {
				$query .= $key . ' = ' . $this->db->quote($value);
			}
			$i++;
		}

		$query .= " WHERE " . $where['col'] . " = " . $this->db->quote($where['val']);

		$result = $this->db->exec($query);

		return $result;
	}

	function create($table, $cols = [], $values = []) {
		$query = "INSERT INTO $table (";

		$i = 0;
		$len = count($cols);
		foreach ($cols as $key => $col) {
			if ($i < $len - 1) {
				$query .= $col . ', ';
			} else {
				$query .= $col;
			}
			$i++;
		}

		$query .= ") VALUES (";

		$i = 0;
		$len = count($values);
		foreach ($values as $key => $value) {
			if ($i < $len - 1) {
				$query .= $this->db->quote($value) . ', ';
			} else {
				$query .= $this->db->quote($value);
			}
			$i++;
		}

		$query .= ")";

		$result = $this->db->exec($query);

		return $this->db->lastInsertId();
	}
}