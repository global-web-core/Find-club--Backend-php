<?php

	require_once __ENGINE	. 'base.php';
	require_once __DAL		. 'accounts.php';

	class AccountsBaseController extends BaseController {

		public function __construct($db, $controllerName) {
			parent::__construct($db, $controllerName);
		}

	}

	require_once 'ext/accounts.php';

?>