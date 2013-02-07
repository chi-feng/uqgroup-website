<?php 

define('INCLUDE_GUARD', true);

date_default_timezone_set('America/New_York');

require_once('includes/publications.php');

$publications  = json_decode(file_get_contents('json/articles.json'), true);
$pages         = json_decode(file_get_contents('json/pages.json'),        true);
$tabs          = json_decode(file_get_contents('json/tabs.json'),         true);
$announcements = json_decode(file_get_contents('json/announcements.json'),true);
$events        = json_decode(file_get_contents('json/events.json'),       true);
$links         = json_decode(file_get_contents('json/links.json'),        true);

// get the requested page
$page = (isset($_GET['p']) && !empty($_GET['p'])) ? $_GET['p'] : 'home';

// template variables
$t = array(); 

// check that $request is in $pages
if (isset($pages[$page]) && file_exists("pages/$page.php")) {

  $t['title'] = $pages[$page]['title'];
  
  // start output buffering to get page contents
  ob_start();
  include("pages/$page.php"); 
  $t['content']  = ob_get_contents();
  ob_end_clean();

} else {
  
  header('HTTP/1.0 404 Not Found');
  die('<h1>Error 404: Page Not Found</h1>' . $page);
    
}

include('includes/header.php');
echo $t['content'];
include('includes/footer.php');

?>