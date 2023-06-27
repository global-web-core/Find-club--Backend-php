<?php

	class helper {
		private static $months = ['января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря'];

		public static function guidGet() {
			if (function_exists('com_create_guid') === true)
				return trim(com_create_guid(), '{}');
			$data = openssl_random_pseudo_bytes(16);
			$data[6] = chr(ord($data[6]) & 0x0f | 0x40);
			$data[8] = chr(ord($data[8]) & 0x3f | 0x80);
			return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
		}

		public static function expireGet() {
			return __TOKEN_EXPIRE == -1 ? -1 : date() + __TOKEN_EXPIRE;
		}

		public static function forbiddenKeysRemove($arr) {
			if (is_array($arr)) {
				for ($i = 0, $j = sizeof($arr); $i < $j; $i++) {
					if (isset($arr[$i]->password)) $arr[$i]->password = null;
				}
			} else {
				if (isset($arr->password)) $arr->password = null;
			}
			return $arr;
		}

		public static function rangeYears($start) {
			$current = date('Y');
			return strcmp($start, $current) == 0 ? $start : $start . '&ndash;' . $current;
		}

		public static function redirect($url = '') {
			header('location: ' . (empty($url) ? '/' : $url));
			exit();
		}

		public static function dateGet($ts, $timeshow = false) {
			$day = (int)date('d', $ts);
			$month = (int)date('m', $ts);
			$year = date('Y', $ts);
			return sprintf('%s %s %s%s', $day, self::$months[$month-1], $year, $timeshow ? sprintf(', %s:%s', date('H', $ts), date('i', $ts)) : '');
		}

		public static function paramGet($data, $key) {
			$baseInfo = new baseInfo($data);
			$conditions = $baseInfo->conditions;
			foreach ($conditions as $c) {
				if ($c->key === $key) return $c->value;
			}
			return null;
		}

		public static function paramRemove($data, $key) {
			$conditions = $data['conditions'];
			$arr = array();
			foreach ($conditions as $c) {
				if ($c['k'] !== $key) array_push($arr, $c);
			}
			return array('conditions' => $arr);
		}

		public static function moneyFormatter($amount) {
			return str_replace('.00', '', number_format($amount, 2, '.', ','));
		}

	}

?>