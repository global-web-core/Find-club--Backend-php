<?php

	require_once __ENGINE	. 'base.php';
	require_once __DAL		. 'desires.php';

	class DesiresBaseController extends BaseController {

		public function __construct($db, $controllerName) {
			parent::__construct($db, $controllerName);
		}

	}

	require_once 'ext/desires.php';

?>