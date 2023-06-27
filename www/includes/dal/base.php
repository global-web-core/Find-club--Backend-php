<?php

	class Base {
		protected $conn;

		private $operationType = array('=', '<>', '<', '>', 'IS NULL', 'IS NOT NULL', 'LIKE');
		private $concatinationType = array('AND', 'OR');

		public function __construct($db) {
			$this->conn = $db;
		}

		protected function set($stmt, $is_array, $className) {
			$arr = array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
				array_push($arr, is_null($className) ? $row : new $className($row));
			return count($arr) > 0 ? ($is_array ? $arr : $arr[0]) : ($is_array ? $arr : null);
		}

		protected function conditions($conditions) {
			if (is_null($conditions) || sizeof($conditions) == 0) return;
			$operationType = $this->operationType;
			$concatinationType = $this->concatinationType;
			return ' WHERE ' . $this->concatinationTrim(implode('', array_map(function($condition) use ($operationType, $concatinationType) {
				if (empty($condition->key)) return;
				$operation = $operationType[$condition->operation];
				$concatination = $concatinationType[$condition->concatination];
				switch ($condition->operation) {
					case 4:
					case 5:
						return sprintf('%s %s %s ', $concatination, ucfirst($condition->key), $operation);
					case 6:
						return sprintf('%s %s LIKE \'%%%s%%\' ', $concatination, ucfirst($condition->key), $condition->value);
				}
				$value = sprintf('\'%s\'', $condition->value);
				if (is_numeric($condition->value) || is_bool($condition->value)) $value = sprintf('%s', $condition->value);
				if (strtolower($condition->key) == 'password') $value = sprintf('MD5(\'%s\')', $condition->value);
				return sprintf('%s %s %s %s ', $concatination, ucfirst($condition->key), $operation, $value);
			}, $conditions)));
		}

		protected function orders($orders) {
			if (is_null($orders) || sizeof($orders) == 0) return;
			return ' ORDER BY ' . $this->commaTrim(implode(', ', array_map(function($order) {
				return sprintf('%s %s', ucfirst($order->key), $order->is_desc ? 'DESC' : 'ASC');
			}, $orders)));
		}

		protected function limits($limits) {
			if (is_null($limits) || sizeof($limits) == 0) return;
			return ' LIMIT ' . $this->commaTrim(implode(', ', array_map(function($limit) {
				return sprintf('%s', $limit);
			}, $limits)));
		}

		protected function updates($updates) {
			$output = '';
			foreach ($updates as $key => $value) {
				if (strtolower($key) == 'id') continue;
				if (is_null($value)) continue;
				if (strtolower($key) == 'password') {
					if (empty($value)) continue;
					$output .= sprintf('`%s` = MD5(%s), ', ucfirst($key), $this->quote($value));
				}
				else if (strtolower($key) == 'datemodify') $output .= sprintf('`%s` = UNIX_TIMESTAMP(), ', ucfirst($key));
				else {
					if (is_numeric($value) && $value == 0) $output .= sprintf('`%s` = %s, ', ucfirst($key), $value);
					else if (empty($value)) $output .= sprintf('`%s` = NULL, ', ucfirst($key));
					else $output .= sprintf('`%s` = %s, ', ucfirst($key), is_numeric($value) ? $this->value($value) : $this->quote($value));
				}
			}
			return $this->commaTrim($output);
		}

		protected function quote($text) {
			return $this->conn->quote(trim(urldecode(($text))));
		}

		protected function value($value) {
			if ($value == '0') return 0;
			if (empty($value)) return 'NULL';
			return $value;
		}

		protected function spacesRemove($text) {
			$text = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $text);
			$text = preg_replace('/,.*$/', '', $text);
			return preg_replace('/\..*$/', '', $text);
		}

		// private

		function commaTrim($text) {
			return rtrim(trim($text), ',');
		}

		function concatinationTrim($text) {
			return trim(preg_replace('/^(AND|OR)/', '', trim($text)));
		}

	}

?>