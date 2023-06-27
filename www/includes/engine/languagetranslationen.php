<?php

	require_once __ENGINE	. 'base.php';
	require_once __DAL		. 'languagetranslationen.php';

	class LanguagetranslationenBaseController extends BaseController {

		public function __construct($db, $controllerName) {
			parent::__construct($db, $controllerName);
		}

	}

	require_once 'ext/languagetranslationen.php';

?>