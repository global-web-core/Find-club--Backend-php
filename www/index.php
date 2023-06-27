<?php
$st = microtime(true);

// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
	// Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
	// you want to allow, and if so:
	header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	header('Access-Control-Allow-Credentials: true');
	//header('Access-Control-Max-Age: 86400');    // cache for 1 day
}
// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
		// may also be using PUT, PATCH, HEAD etc
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
		header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
	exit;
}

// settings ERROR_LEVEL
if (error_reporting() == 0) {
	error_reporting(E_ALL & ~E_STRICT);
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
} else {
	error_reporting(E_ALL & ~E_NOTICE);
	ini_set('error_reporting', E_NOTICE);
	ini_set('display_errors', 0);
}

error_reporting(E_ALL & ~E_STRICT);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

version_compare(PHP_VERSION, '5.2', '<') and exit('Requires PHP 5.2 or newer.');

// paths
define('__SITE_PATH',	realpath(dirname(__FILE__)) . '/');
define('__CONFIG',		__SITE_PATH . 'config/');
define('__HELPERS',		__SITE_PATH . 'includes/helpers/');
define('__ENGINE',		__SITE_PATH . 'includes/engine/');
define('__DAL',			__SITE_PATH . 'includes/dal/');
define('__ENTITIES',	__SITE_PATH . 'includes/entities/');
define('__ENUMS',		__SITE_PATH . 'includes/enums/');

// logs
define('__LOGS',		__SITE_PATH . 'logs/');

// paths assets
define('__ASSETS',		__SITE_PATH . 'assets/');

include_once __CONFIG . 'config.php';
include_once __CONFIG . 'config.access.php';
include_once __CONFIG . 'config.db.php';

// include classes
require __HELPERS . 'eo.php';
require __HELPERS . 'common.php';
require __HELPERS . 'helper.php';
require __HELPERS . 'cookies.php';
require __HELPERS . 'database.php';
require __HELPERS . 'exceptions.php';
require __HELPERS . 'uri.php';
require __HELPERS . 'minify.php';
require __HELPERS . 'logs.php';

// main class
$eo = new eo();
$eo->startTime = $st;

// uri
$eo->uri = new uri();

// database
$db_cfg = $DB[DB_ENVIRONMENT];
$database = new database($db_cfg['host'], $db_cfg['database'], $db_cfg['username'], $db_cfg['password']);

if (!$eo->uri->isapi) {
	exit;
}

// api block

// output
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: *");
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json; charset=UTF-8');

try {
	$eo->db = $database->getConnection();

	$ctrl = $eo->uri->controller;
	$action = $eo->uri->action;
	$id = $eo->uri->id;

	if ($ctrl == '' || $action == '') throw new ForbiddenException('You are forbidden');

	// check access
	$access = new access();
	if (!$access->allow(new accessInfo($ctrl, $action))) throw new ForbiddenException('You are forbidden');

	if ($ctrl == 'tokens') {
		// tokens handler
		throw new ForbiddenException('Operation not allowed');
	}

	// get POST data
	$postData = file_get_contents('php://input');
	$postData = json_decode($postData, true);
	if ($_POST) $postData = $_POST;

	// logs
	if ($ctrl == 'logs' && $action == 'add') {
		Logs::add($postData);
		echo json_encode(array('code' => 0));
		exit;
	}

	// security
	require __ENGINE . 'tokens.php';

	$tokens = new TokensController($eo->db, 'tokens');

	if ($ctrl === 'users' && $action === 'login') {
	} else {
		// определить список методов которым НЕ нужен токен! либо ждать от них secret key

		if ($ctrl === 'no-token-call') {
		}
		else {
			$headers = getallheaders();
			$token = isset($headers['Authentication']) ? $headers['Authentication'] : (isset($headers['authentication']) ? $headers['authentication'] : null);
			if (is_null($token)) throw new AuthException('Token not found');
			if ($token === __API_KEY) $tokenInfo = tokenInfo::create(0, 0, $token);
			else {
				$tokenInfo = $tokens->get(array('conditions' => array(array('k' => 'token', 'v' => $token))));
				if (empty($tokenInfo)) throw new AuthException('Token expire');
			}
		}
	}

	// main action
	$ctrl_file = __ENGINE . $ctrl . '.php';
	if (!file_exists($ctrl_file)) throw new NotFoundException('Method not found');

	require $ctrl_file;
	$controllerName = $ctrl . 'controller';
	$class = new $controllerName($eo->db, $ctrl);

	if (!method_exists($class, $action)) throw new NotFoundException('Action not found');

	$data = $class->$action($postData);
	$data = helper::forbiddenKeysRemove($data);

	$eo->output = array('code' => 0, 'data' => $data);
}
catch(DBException $ex) {
	Logs::add($ex, 'dbexception.index.api');
	header('HTTP/1.0 400 Bad Request');
	$eo->output = array('code' => 2, 'message' => $ex->message);
}
catch(ForbiddenException $ex) {
	Logs::add($ex, 'forbiddenexception.index.api');
	header('HTTP/1.0 403 Forbidden');
	$eo->output = array('code' => 3, 'message' => $ex->message);
}
catch(AuthException $ex) {
	Logs::add($ex, 'authexception.index.api');
	header('HTTP/1.0 401 Unauthorized');
	$eo->output = array('code' => 4, 'message' => $ex->message);
}
catch(ArgumentException $ex) {
	Logs::add($ex, 'argument.index.api');
	header('HTTP/1.0 500 Internal Server Error');
	$eo->output = array('code' => 5, 'message' => $ex->message);
}
catch(NotFoundException $ex) {
	Logs::add($ex, 'notfoundexception.index.api');
	header('HTTP/1.0 404 404 Not Found', true);
	$eo->output = array('code' => 6, 'message' => $ex->message);
}
catch(Exception $ex) {
	Logs::add($ex);
	header('HTTP/1.0 500 Internal Server Error');
	$eo->output = array('code' => 1, 'message' => $ex);
}

// output
echo json_encode($eo->output);

?>