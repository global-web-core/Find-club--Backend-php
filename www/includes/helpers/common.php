<?php

	class common {

		public static function debug($obj, $stop = true) {
			echo '<pre>'; var_dump($obj); echo '</pre>';
			if ($stop) exit;
		}

		public static function classCreate($name, $properties = null) {
			$arr = array();
			if (!is_null($properties)) {
				if (is_array($properties)) {
					foreach ($properties as $k => $v) {
						if (is_numeric($k)) $arr = array_merge($arr, array($v => null));
						else $arr = array_merge($arr, array($k => $v));
					}
				} else $arr = array_merge($arr, array($properties => null));
			}
			return (object)$arr;
		}

	}

?>