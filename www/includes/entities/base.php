<?php

	require_once __ENUMS			. 'baseconcatinationtype.php';
	require_once __ENUMS			. 'baseconditionoperationtype.php';
	require_once __ENUMS			. 'baseordertype.php';

	class baseInfo {

		public $data, $conditions, $orders, $limits;

		public function __construct($data = null) {
			if (is_null($data)) return $this;
			if ($data instanceof baseInfo) {
				$this->data = $data->data;
				$this->conditions = $data->conditions;
				$this->orders = $data->orders;
			} else {
				$this->data = isset($data['data']) ? $data['data'] : null;
				$conditions = isset($data['conditions']) ? $data['conditions'] : null;
				$orders = isset($data['orders']) ? $data['orders'] : null;
				$limits = isset($data['limits']) ? $data['limits'] : null;
				if (!is_null($conditions)) {
					$this->conditions = array();
					for ($i = 0, $j = sizeof($conditions); $i < $j; $i++)
						array_push($this->conditions, new baseConditionInfo($conditions[$i]));
				}
				if (!is_null($orders)) {
					$this->orders = array();
					for ($i = 0, $j = sizeof($orders); $i < $j; $i++)
						array_push($this->orders, new baseOrderInfo($orders[$i]));
				}
				if (!is_null($limits)) {
					$this->limits = array();
					for ($i = 0, $j = sizeof($limits); $i < $j; $i++)
						array_push($this->limits, intval($limits[$i]));
				}
			}
			return $this;
		}

		public static function create($data, $conditions = null, $orders = null, $limits = null) {
			$instance = new self(null);
			$instance->data = $data;
			$instance->conditions = $conditions;
			$instance->orders = $orders;
			$instance->limits = $limits;
			return $instance;
		}

	}

	class baseConditionInfo {

		public $key, $value, $operation, $concatination;

		public function __construct($data) {
			$this->key = isset($data['k']) ? $data['k'] : null;
			$this->value = isset($data['v']) ? $data['v'] : null;
			$this->operation = isset($data['op']) ? (int)$data['op'] : 0;
			$this->concatination = isset($data['con']) ? (int)$data['con'] : 0;
			return $this;
		}

		public static function create($key, $value, $operation = null, $concatination = null) {
			$instance = new self(null);
			$instance->key = $key;
			$instance->value = $value;
			$instance->operation = $operation == null ? BaseConditionOperationTypeEnum::EQUAL : $operation;
			$instance->concatination = $concatination == null ? BaseConcatinationTypeEnum::CON_AND : $concatination;
			return $instance;
		}

	}

	class baseOrderInfo {

		public $key, $is_desc;

		public function __construct($data) {
			$this->key = isset($data['k']) ? $data['k'] : null;
			$this->is_desc = isset($data['isd']) ? (int)$data['isd'] : 0;
			return $this;
		}

		public static function create($key, $is_desc) {
			$instance = new self(null);
			$instance->key = $key;
			$instance->is_desc = $is_desc == null ? BaseOrderTypeEnum::ASC : $is_desc;
			return $instance;
		}

	}

	class outInfo {

		public $code, $data;

		public function __construct($data) {
			$this->code = isset($data['code']) ? (int)$data['code'] : 0;
			$this->data = isset($data['data']) ? $data['data'] : null;
			return $this;
		}

	}

?>