<?php

	class cookies {

		static public function set($name, $value, $expire = null) {
			$name = self::scrubKey($name, true);
			setcookie($name, $value, $expire, '/', false);
			$_COOKIE[$name] = $value;
		}

		static public function setLong($name, $value) {
			self::set($name, $value, self::year());
		}

		static public function get($name) {
			$name = self::scrubKey($name);
			if (is_array($name)) {
				list ($k, $v) = each($name);
				if (isset($_COOKIE[$k][$v])) return $_COOKIE[$k][$v];
			}
			else if (isset($_COOKIE[$name])) return $_COOKIE[$name];
			return null;
		}

		static public function delete($name) {
			$name = self::scrubKey($name);
			if (self::exists($name)) {
				if (is_array($name)) {
					list ($k, $v) = each($name);
					$name = $k . '[' . $v . ']';
					self::set($name, false, self::past());
					unset($_COOKIE[$k][$v]);
				}
				else if (is_array($_COOKIE[$name])) {
					foreach ($_COOKIE[$name] as $k => $v) {
						$name = $name . '[' . $k . ']';
						self::set($name, false, self::past());
						unset($_COOKIE[$name][$k]);
					}
				}
				else {
					self::set($name, null, self::past());
					unset($_COOKIE[$name]);
				}
			}
		}

		static public function exists($name) {
			$name = self::scrubKey($name);
			if (is_array($name)) {
				list ($k, $v) = each($name);
				if (isset($_COOKIE[$k][$v])) return true;
			}
			else if (isset($_COOKIE[$name])) return true;
			return false;
		}

		static private function scrubKey($name, $toString = false) {
			if ($toString) {
				if (is_array($name)) {
					list ($k, $v) = each($name);
					$name = $k . '[' . $v . ']';
				}
			}
			else if (!is_array($name)) {
				if (preg_match('/([\w\d]+)\[([\w\d]+)\]$/i', $name, $matches))
					$name = array($matches[1] => $matches[2]);
			}
			return $name;
		}

		static public function year() {
			return time() + 60 * 60 * 24 * 365;
		}
		static public function halfYear() {
			return time() + 60 * 60 * 24 * 30 * 6;
		}
		static public function month() {
			return time() + 60 * 60 * 24 * 30;
		}
		static public function week() {
			return time() + 60 * 60 * 24 * 7;
		}
		static public function day() {
			return time() + 60 * 60 * 24;
		}
		static public function past() {
			return time() - 60 * 60;
		}

	}

?>