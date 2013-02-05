<?php 

session_start();

date_default_timezone_set('America/New_York');

define('TIMEOUT', 6000);
define('EOL', "\n");

$key = 'herpderp'; // for csrf, TODO: read from file
$iv = '1234567812345678'; // initialization vector

$users = array(
  'chifeng' => array('password' => '$2a$10$es5UK4mYTwoaTkgSXXLEfOg6RcbcYa.FZHFCzGFWvhxbFxzyHeLEm'),
  'ymarz' => array('password' => '$2a$10$NimQpAYrgRGEL5HYyqB5NOJr9x0XT/C.R6uPKquOk23hQkth6lJ7C'),
);

require_once('includes/admin_functions.php');
require_once('includes/json.php');
require_once('includes/Bcrypt.php');
require_once('includes/publications.php');

$publications  = json_decode(file_get_contents('json/publications.json'), true);
$pages         = json_decode(file_get_contents('json/pages.json'),        true);
$tabs          = json_decode(file_get_contents('json/tabs.json'),         true);
$announcements = json_decode(file_get_contents('json/announcements.json'),true);
$events        = json_decode(file_get_contents('json/events.json'),       true);
$links         = json_decode(file_get_contents('json/links.json'),        true);

ob_start();

$template = array();
$errors = array();
$warnings = array();

// process login

if (isset($_POST['login']) && !isset($_SESSION['logged_in'])) {
  
  $ip = bcrypt_decrypt($_POST['a'], $key, $iv);
  if ($_SERVER['REMOTE_ADDR'] != $ip) die ('bad IP');
  $username = $_POST['username'];
  $password = $_POST['password'];
  if (isset($users[$username])) {
    if (bcrypt_verify($password, $users[$username]['password'])) {
      $_SESSION['logged_in'] = true;
      $_SESSION['timestamp'] = time();
      $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
      header('Location: admin');
    } else {
      display_login_form('Username/password mismatch.');
    }
  } else {
    display_login_form('Username not found.');
  } 
  
// user is not logging in, check if trying to log out, or not logged in 
  
} else if (!isset($_SESSION['logged_in']) || isset($_GET['logout'])) {
  
  if (session_id() != '') {
    unset($_SESSION['logged_in']);
    session_destroy();
    display_login_form();
  } else {
    display_login_form();
  }
  
// here, session is set, not logging in or logging out
  
} else { 
  
  if ($_SERVER['REMOTE_ADDR'] != $_SESSION['ip']) {
    logout('You have been automatically logged out since your IP has changed.');
  } elseif (time() - $_SESSION['timestamp'] > TIMEOUT) {
    logout('Session timed out.');
  } else {
    
    // we are logged in and the session is okay and we aren't trying to log out
    
    $_SESSION['timestamp'] = time();
    
    check_permissions();
    
    // process requests and output goes to buffer
    
    if (isset($_POST['new_event'])) {
      new_event();
    } elseif (isset($_POST['new_announcement'])) {
      new_announcement();
    } elseif (isset($_POST['new_article'])) {
      new_article();
    } elseif (isset($_GET['edit_article'])) {
      edit_article();
    } else {
      
    }
    
    // generate page contents
    get_sidebar_forms();
    get_articles_forms();
    
  }
  
}

$template['content'] = ob_get_contents();
ob_end_clean();

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <!--<link href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css"  rel="stylesheet" type="text/css" />-->
  <link href='http://fonts.googleapis.com/css?family=Titillium+Web:300' rel='stylesheet' type='text/css'>
  <link href="http://netdna.bootstrapcdn.com/font-awesome/3.0/css/font-awesome.css"  rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
  <script type="text/javascript" src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>

  <link rel="stylesheet" type="text/css" href="css/admin.css" media="screen" />
  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  <link rel="shortcut icon" href="favicon.ico" />    
</head>
<body>
  
<div class="menubar">
  <?php
  if (isset($_SESSION['logged_in']) && count($errors) + count($warnings) == 0) {
    echo '<div class="status green"><p>File permissions OK</p></div>'.EOL;
  }
  ?>
  <a href="home" class="home-button" >Home</a>
  <?php if (isset($_SESSION['logged_in'])) { ?>
    <a href="logout" class="logout-button" >Logout</a>
  <?php } ?>
</div>
  
<div id="content-wrap" class="clearfix">
<?php echo $template['content']; ?>  
</div>

<script type="text/javascript">

$(document).ready(function() {
  $('div').addClass('clearfix');
  $('div.message').delay(1000).fadeOut(500);
});

// jquery ui autocomplete 
var authors = [ <?php $authors = get_article_authors(); echo "'".implode("','",$authors)."'"; ?> ]; 
var journals = [ <?php $journals = get_article_journals(); echo "'".implode("','",$journals)."'"; ?> ];
$(function() {
  $( "#journal-textbox" ).autocomplete({ source: journals });
  $( "input.author" ).autocomplete({ source: authors });
});

</script>
</body>
</html>