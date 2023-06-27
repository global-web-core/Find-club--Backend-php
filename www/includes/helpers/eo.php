<?php

	class eo {

		public $output = array(), $startTime = 0;
		private static $instance = null;

		function __construct($charset = 'UTF-8', $language = 'RU') {
			self::$instance = $this;
		}

		public function getInstance() {
			if(is_null(self::$instance))
				self::$instance = new eo;
			return self::$instance; 
		}

		public function loaded($isminify = false) {
			if ($isminify) {
				//$this->output = str_replace(array("\r\n", "\r", "\n"), '', $this->output);
				//$this->output = preg_replace('/>\s+</', '><', $this->output);
				$this->output = minify::all($this->output);
			}
			$rn = "\r\n";
			$this->output = sprintf('%s%s%s<!-- © pavit.design, %s | https://pavit.design/ -->%s<!-- %s -->', $this->output, $rn, $rn, str_replace('&ndash;', '–', helper::rangeYears(1999)), $rn, (microtime(true) - $this->startTime));
			return $this;
		}

		public function render() {
			echo $this->output;
		}

	}

?>