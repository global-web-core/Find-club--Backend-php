<?php

	class BaseException extends Exception {

		public $message;

		function __construct($message, $savelog = true) {
			if ($savelog) Logs::event($message);
			$this->message = $message;
		}
	}

	class ExitException extends BaseException {
		function __construct($message) {
			parent::__construct($message);
		}
	}

	class DBException extends BaseException {
		function __construct($message) {
			parent::__construct($message);
		}
	}

	class AuthException extends BaseException {
		function __construct($message) {
			parent::__construct($message);
		}
	}

	class ForbiddenException extends BaseException {
		function __construct($message) {
			parent::__construct($message);
		}
	}

	class NotFoundException extends BaseException {
		function __construct($message) {
			parent::__construct($message);
		}
	}

	class ArgumentException extends BaseException {
		function __construct($message) {
			parent::__construct($message);
		}
	}

?>