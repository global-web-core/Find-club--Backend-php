<?php

// init
ini_set('max_execution_time', 1800); // 15 minutes


$path = 'includes/';

$names = array(
	// 'accounts',	//   includes/dal/accounts.php    в  public function add(userInfo $data) { сюда вставил Id так как он не стандартный а string который генерируется на фронте а не auto increment     
	'categories',
	'categoriesbyinterests',
	'cities',
	'citiesbycountries',
	'countries',
	'interests',
	'interestsbycities',
	'languages',
	'languagetranslationen',
	'languagetranslationru',
	// 'sessions',		//   includes/dal/sessions.php    в  public function add(userInfo $data) { сюда вставил Id так как он не стандартный а string который генерируется на фронте а не auto increment 
	// 'users',    //   includes/dal/users.php    в  public function add(userInfo $data) { сюда вставил Id так как он не стандартный а string который генерируется на фронте а не auto increment     
	'verificationtokens',
	// 'meetings',    //  includes/dal/meetings.php    в public function add(meetingInfo $data) { сюда вставил условие о том что если не прилетает DateModification то тогда запрос на доавление в БД сделать без этого параметра. А если прилетает DateModification то тогда в запрос к БД включается DateModification
	'desires',
);

for ($i = 0, $j = sizeof($names); $i < $j; $i++)
	mainLoop($names[$i], $path);

echo 'Done!<br>' . date('Y-m-d H:i:s');
exit;

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function mainLoop($name, $path) {
	require('./config/config.db.php');

	$db = new PDO(
		"mysql:host=db;dbname=" . $DB["development"]["database"],
		$DB["development"]["username"],
		$DB["development"]["password"]
	);


	$res = $db->prepare('DESCRIBE ' . $name);
	$res->execute();

	$arr = array();
	$types = array();
	while($row = $res->fetch(PDO::FETCH_ASSOC)) {
		array_push($arr, $row['Field']);
		array_push($types, $row['Type']);
	}

	fileCreate($path . 'entities/' . iesToY($name) . '.php', entitieCreate($name, $arr, $types));

	fileCreate($path . 'dal/' . $name . '.php', dalCreate($name, $arr, $types));
	@mkdir($path . 'dal/ext/');
	fileCreate($path . 'dal/ext/' . $name . '.php', dalExtCreate($name));

	fileCreate($path . 'engine/' . $name . '.php', controllerCreate($name));
	@mkdir($path . 'engine/ext/');
	fileCreate($path . 'engine/ext/' . $name . '.php', controllerExtCreate($name));
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function fileCreate($filename, $content) {
	$fp = fopen($filename, 'w');
	fwrite($fp, $content);
	fclose($fp);

	@chmod($filename, 0777);
}

function commaTrim($text) {
	return rtrim(trim($text), ',');
}

function iesToY($text) {
	if ($text == 'sms' || $text == 'push') return $text;
	$text = preg_replace('/ies$/', 'y', $text);
	$text = preg_replace('/es$/', '', $text);
	$text = preg_replace('/s$/', '', $text);
	return $text;
}

function entitieCreate($className, $properties, $types) {
	$properties_list_inline = '';
	$properties_list_inline_null = '';
	$properties_list1 = '';
	$properties_list2 = '';
	$properties_list_instance = '';
	$nl = "\r\n";
	$tab = '					';
	$tab2 = '			';

	for ($i = 0, $j = sizeof($properties); $i < $j; $i++) {
		$properties_list_inline .= sprintf('$%s, ', lcfirst($properties[$i]));
		$properties_list_inline_null .= sprintf('$%s%s, ', lcfirst($properties[$i]), $i === 0 ? null : ' = null');
		$value = lcfirst($properties[$i]);
		if (strrpos($types[$i], 'int') !== false) {
			$properties_list1 .= sprintf($tab . '$this->%s = isset($data[\'%s\']) ? (int)$data[\'%s\'] : 0;' . $nl, $value, $value, $value);
			$properties_list2 .= sprintf($tab . '$this->%s = (int)$data[\'%s\'];' . $nl, $value, $properties[$i]);
		}
		else if (strrpos($types[$i], 'float') !== false) {
			$properties_list1 .= sprintf($tab . '$this->%s = isset($data[\'%s\']) ? (float)$data[\'%s\'] : 0;' . $nl, $value, $value, $value);
			$properties_list2 .= sprintf($tab . '$this->%s = (float)$data[\'%s\'];' . $nl, $value, $properties[$i]);
		}
		else if (strrpos($types[$i], 'double') !== false) {
			$properties_list1 .= sprintf($tab . '$this->%s = isset($data[\'%s\']) ? (double)$data[\'%s\'] : 0;' . $nl, $value, $value, $value);
			$properties_list2 .= sprintf($tab . '$this->%s = (double)$data[\'%s\'];' . $nl, $value, $properties[$i]);
		}
		else {
			$properties_list1 .= sprintf($tab . '$this->%s = isset($data[\'%s\']) ? $data[\'%s\'] : null;' . $nl, $value, $value, $value);
			$properties_list2 .= sprintf($tab . '$this->%s = $data[\'%s\'];' . $nl, $value, $properties[$i]);
		}
		$properties_list_instance .= sprintf($tab2 . '$instance->%s = $%s;' . $nl, $value, $value);
	}

	return sprintf('<?php

	class %sInfo {

		public %s;

		function __construct($data = null, $fromArray = false) {
			if (!is_null($data)) {
				if ($fromArray) {
					%s
				}
				else {
					%s
				}
			}
			return $this;
		}

		public static function create(%s) {
			$instance = new self(null);
			%s
			return $instance;
		}

	}

?>', iesToY($className), commaTrim($properties_list_inline), trim($properties_list1), trim($properties_list2), commaTrim($properties_list_inline_null), trim($properties_list_instance));
}

function dalCreate($className, $properties, $types) {
	$classNameY = iesToY($className);
	$keys = '';
	$values = '';

	for ($i = 0, $j = sizeof($properties); $i < $j; $i++) {
		$key = $properties[$i];
		$val = '';

		if ($key == 'DateModify' || $key == 'Id') continue;
		if ($key == 'Password') $val = sprintf('MD5(\' . parent::quote($data->%s) . \'), ', lcfirst($key));
		else if ($key == 'DateCreate') $val = 'UNIX_TIMESTAMP(), ';
		else $val = sprintf((strrpos($types[$i], 'int') !== false || strrpos($types[$i], 'float') !== false || strrpos($types[$i], 'double') !== false) ? '\' . parent::value(isset($data->%s) ? $data->%s : NULL) . \', ' : '\' . parent::quote(isset($data->%s) ? $data->%s : NULL) . \', ', lcfirst($key), lcfirst($key));

		$keys .= sprintf('%s, ', $key == 'Values' ? sprintf('`%s`', $key) : $key);
		$values .= $val;
	}

	$get = sprintf('public function get($conditions, $orders, $limits) {
			$stmt = $this->conn->prepare(\'SELECT * FROM %s\' . parent::conditions($conditions) . parent::orders($orders) . parent::limits($limits));
			$stmt->execute();
			return parent::set($stmt, true, \'%sInfo\');
		}', $className, $classNameY);

	$insert = sprintf('public function add(%sInfo $data) {
			$stmt = $this->conn->prepare(\'INSERT INTO %s ( %s ) VALUES ( %s )\');
			$stmt->execute();
			return array(\'id\' => $this->conn->lastInsertId());
		}', $classNameY, $className, commaTrim($keys), commaTrim($values));

	$update = sprintf('public function update(%sInfo $data, $conditions) {
			$this->conn->prepare(\'UPDATE %s SET \' . parent::updates($data) . parent::conditions($conditions))->execute();
		}', $classNameY, $className);


	$delete = sprintf('public function delete($conditions) {
			$this->conn->prepare(\'DELETE FROM %s\' . parent::conditions($conditions))->execute();
		}', $className);

	return sprintf('<?php

	require_once __DAL			. \'base.php\';
	require_once __ENTITIES		. \'%s.php\';

	class %sBase extends Base {

		%s

		%s

		%s

		%s

	}

	require_once \'ext/%s.php\';

?>', iesToY($className), ucfirst($className), $get, $insert, $update, $delete, $className);
}

function dalExtCreate($className) {
	$className = ucfirst($className);

	return sprintf('<?php

	class %s extends %sBase {

	}

?>', $className, $className);
}

function controllerCreate($className) {
	return sprintf('<?php

	require_once __ENGINE	. \'base.php\';
	require_once __DAL		. \'%s.php\';

	class %sBaseController extends BaseController {

		public function __construct($db, $controllerName) {
			parent::__construct($db, $controllerName);
		}

	}

	require_once \'ext/%s.php\';

?>', $className, ucfirst($className), $className);
}

function controllerExtCreate($className) {
	$className = ucfirst($className);

	return sprintf('<?php

	class %sController extends %sBaseController {

	}

?>', $className, $className);
}

?>