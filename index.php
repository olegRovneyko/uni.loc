<?php
require __DIR__ . '/autoload.php';

/*$url = $_SERVER['REQUEST_URI'];
$url = rtrim($url, '/');
$url = explode('/', $url);
array_shift($url);

if (count($url) == 0) {
	$controller = new \App\Controllers\Order();
} else {
	switch ($url[0]) {
		case 'client':
			$controller = new \App\Controllers\Client();
			break;
		case 'performer':
			$controller = new \App\Controllers\Performer();
			break;
		default:
			$controller = new \App\Controllers\Order();
	}
}

if (isset($url[1])) {
	$action = $url[1];
} else {
	$action = 'Index';
}

$controller->action($action);

die();*/

if (empty($_GET['controller'])) {
	$controller = new \App\Controllers\Order();
} elseif ($_GET['controller'] == 'client') {
	$controller = new \App\Controllers\Client();
} elseif ($_GET['controller'] == 'performer') {
	$controller = new \App\Controllers\Performer();
}

$action = $_GET['action'] ? : 'Index';

$controller->action($action);