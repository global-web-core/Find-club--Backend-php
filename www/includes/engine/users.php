<?php

	require_once __ENGINE	. 'base.php';
	require_once __DAL		. 'users.php';

	class UsersBaseController extends BaseController {

		public function __construct($db, $controllerName) {
			parent::__construct($db, $controllerName);
		}

	}

	require_once 'ext/users.php';

?>