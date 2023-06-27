<?php

	class uri {

		public $controller, $action, $id;
		public $path = array();
		public $qs = array();
		public $isapi = false;
		public $origin;

		function __construct() {
			$path = trim($this->getQS(), '?/');
			$this->origin = str_replace('p=', '', strtolower($path));
			$pos = strpos($path, '&');
			if ($pos) {
				$qs = trim(substr($path, $pos), '?&/');
				if (!empty($qs)) parse_str($qs, $this->qs);
				$path = substr($path, 0, $pos);
			}
			$arr = explode('/', $path);
			if (is_array($arr)) {
				if (!empty($arr[0])) {
					$arr[0] = str_replace('p=', '', $arr[0]);
					$this->path = $arr;
					if ($arr[0] == 'api') {
						$this->isapi = true;
						if (isset($arr[1])) $this->controller = $arr[1];
						if (isset($arr[2])) $this->action = $arr[2];
						if (isset($arr[3])) $this->id = (int)$arr[3];
					}
				}
			}
		}

		static public function host() {
			return $_SERVER['HTTP_HOST'];
		}

		private function getQS() {
			$qs = $_SERVER['QUERY_STRING'];
			return isset($qs) ? strtolower($qs) : null;
		}

	}

?>