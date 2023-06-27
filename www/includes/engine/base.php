<?php

	require_once __ENTITIES		. 'base.php';

	class BaseController {
		private $output = array(), $className;
		protected $conn, $controller;

		public function __construct($db, $controllerName) {
			$this->conn = $db;
			$this->controller = new $controllerName($this->conn);
			$this->className = $this->infoClassGet($controllerName);
		}

		// general methods

		public function get($data = null) {
			$baseInfo = $this->baseInfoGet($data, false);
			return $this->controller->get($baseInfo->conditions, $baseInfo->orders, $baseInfo->limits);
		}

		public function add($data = null) {
			$baseInfo = $this->baseInfoGet($data, false);
			if ($baseInfo->data == null) throw new DBException('No data specified in add method');
			$res = $this->controller->add($baseInfo->data);
			Logs::add(null);
			return $res;
		}

		public function update($data = null) {
			$baseInfo = $this->baseInfoGet($data, true);
			if ($baseInfo->data == null) throw new DBException('No data specified in update method');
			$this->controller->update($baseInfo->data, $baseInfo->conditions);
			Logs::add(null);
		}

		public function delete($data = null) {
			$baseInfo = $this->baseInfoGet($data, true);
			$this->controller->delete($baseInfo->conditions);
			Logs::add(null);
		}

		// protected methods

		protected function baseInfoGet($data, $checkConditions) {
			$baseInfo = null;
			if ($data instanceof baseInfo) $baseInfo = $data;
			else $baseInfo = $this->toBase($data);
			if ($checkConditions) {
				if ($baseInfo->conditions == null || sizeof($baseInfo->conditions) == 0) throw new DBException('No conditions specified');
			}
			return $baseInfo;
		}

		// private methods

		private function toBase($data) {
			$baseInfo = new baseInfo($data);
			$baseInfo->data = $this->toObject(is_null($baseInfo->data) ? array() : $baseInfo->data, $this->className);
			return $baseInfo;
		}

		private function toObject(array $array = null, $className) {
			if (is_null($array)) return new $className(null);
			$obj = new $className($array, true);
			foreach ($obj as $k => $v) {
				if (!isset($array[$k]))
					unset($obj->{$k});
			}
			return $obj;
		}

		private function infoClassGet($controller) {
			if ($controller != 'sms' && $controller != 'push') {
				$controller = preg_replace('/ies$/', 'y', $controller);
				$controller = preg_replace('/es$/', '', $controller);
				$controller = preg_replace('/s$/', '', $controller);
			}
			return $controller . 'Info';
		}

	}

?>