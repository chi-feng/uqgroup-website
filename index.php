<?php 

date_default_timezone_set('America/New_York');

require_once('includes/template.php');
require_once('includes/publications.php');

// get route from request URI, e.g. /foo/bar/1 -> array('foo','bar','1')
$requestURI = explode('/', $_SERVER['REQUEST_URI']);
$scriptName = explode('/', $_SERVER['SCRIPT_NAME']);
for ($i = 0; $i < sizeof($scriptName); $i++)
	if ($requestURI[$i] === $scriptName[$i])
  		unset($requestURI[$i]);
$route = array_values($requestURI);
if (empty($route[0]))
	$route = array('home');

$request = implode($route, '/');
if (!file_exists("pages/$request.php")) {
	header("HTTP/1.0 404 Not Found");
	$request = '404';
}

$template = Template::getInstance();
$template->header = 'includes/header.php';
$template->footer = 'includes/footer.php';

ob_start();
include("pages/$request.php");
$template->content = ob_get_contents();
ob_end_clean();

$template->render();

?>
