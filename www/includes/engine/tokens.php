<?php

	require_once __ENGINE	. 'base.php';
	require_once __DAL		. 'tokens.php';

	class TokensBaseController extends BaseController {

		public function __construct($db, $controllerName) {
			parent::__construct($db, $controllerName);
		}

	}

	require_once 'ext/tokens.php';

?>