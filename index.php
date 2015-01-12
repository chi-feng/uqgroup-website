<?php 

date_default_timezone_set('America/New_York');

require_once('includes/common.php');
require_once('includes/template.php');
require_once('includes/publications.php');

$route = get_route();

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
