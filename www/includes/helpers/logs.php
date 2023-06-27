<?php

	class Logs {

		public static function add($data, $point = null, $is404 = false) {
			if (is_null($data)) return;
			$output = null;
			if (is_string($data)) $output = $data;
			else {
				ob_start();
					common::debug($data, false);
					$output = ob_get_contents();
				ob_end_clean();
			}
			$caller = isset(debug_backtrace()[1]);
			$className = $caller ? $caller['class'] : '-';
			$methodName = $caller ? $caller['function'] : '-';
			$log = date('Y.m.d H:m:s') . PHP_EOL . 'IP: ' . $_SERVER['REMOTE_ADDR'] . PHP_EOL . 'Point: ' . (is_null($point) ? '-' : $point) . PHP_EOL . 'Class/Method: ' . sprintf('%s/%s', $className, $methodName) . PHP_EOL . 'Message: ' . $output . PHP_EOL . '-------------------------' . PHP_EOL;
			
			$filename = $is404 ? __LOGS . '/404/' . date('Y-m-d') . '.log' : __LOGS . date('Y-m-d') . '.log';
			
			file_put_contents($filename, $log, FILE_APPEND);
		}

		public static function event($data) { }

	}

?>