<?php 

session_start();

date_default_timezone_set('America/New_York');

define('TIMEOUT', 6000);
define('EOL', "\n");


$key = 'herpderp'; // for csrf, TODO: read from file
$iv = '1234567812345678'; // initialization vector

$users = array(
  'chifeng' => array(  
    'name' => 'Chi Feng', 
    'password' => '$2a$10$es5UK4mYTwoaTkgSXXLEfOg6RcbcYa.FZHFCzGFWvhxbFxzyHeLEm')
);

function handleError($errno, $errstr, $errfile, $errline, array $errcontext) {
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
        return false;
    }
    // do nothing
}
// set_error_handler('handleError');

require_once('includes/Bcrypt.php');
  
require_once('includes/publications.php');

$publications  = json_decode(file_get_contents('json/publications.json'), true);
$pages         = json_decode(file_get_contents('json/pages.json'),        true);
$tabs          = json_decode(file_get_contents('json/tabs.json'),         true);
$announcements = json_decode(file_get_contents('json/announcements.json'),true);
$events        = json_decode(file_get_contents('json/events.json'),       true);
$links         = json_decode(file_get_contents('json/links.json'),        true);

ob_start();

function display_login_form($message='') {
  global $key, $iv;
  $client_ip = bcrypt_encrypt($_SERVER['REMOTE_ADDR'], $key, $iv);
  $hidden_fields = sprintf('<input type="hidden" name="a" value="%s">', $client_ip);
  if (!empty($message)) {
    echo '<div class="message">' . $message .'</div>';
  }
  echo '<form action="admin" method="post" class="centered">
  <fieldset>
  <legend>Login</legend>
  <label for="username">Username</label>
  <input type="text" name="username" autocomplete="off" /><br />
  <label for="username">Password</label>
  <input type="password" name="password" autocomplete="off" /><br />
  ' . $hidden_fields . '
  <input type="hidden" name="login" value="true" />
  <label></label>
  <input type="submit" value="Login" class="btn" />
  </form>';
}


function logout($message) {
  unset($_SESSION['logged_in']);
  if (session_id()!='') {
    session_destroy();
  }
  display_login_form($message);
}

function new_article() {
  $article = array();
  $article['title'] = $_POST['title'];
  $article['fulltext'] = $_POST['fulltext'];
  $article['title'] = $_POST['title'];
  $article['journal'] = $_POST['journal'];
  $article['month'] = $_POST['month'];
  $article['year'] = $_POST['year'];
  $article['volume'] = $_POST['volume'];
  $article['number'] = $_POST['number'];
  $article['pages'] = $_POST['pages'];
  $article['keywords'] = $_POST['keywords'];
  $article['thumbnail'] = $_POST['thumbnail'];
  $article['doi'] = $_POST['doi'];
  $article['abstract'] = $_POST['abstract'];
  $article['comments'] = $_POST['comments'];
  $authors = array();
  for($i=1;$i<=8;$i++) {
    $postvar = $_POST['author-'.strval($i)];
    if (!empty($postvar)) {
      $authors[] = $postvar;
    }
  }
  $article['authors'] = $authors;
  global $publications;
  array_unshift($publications['articles'], $article);
  save_publications();
  echo '<div class="message">Saved new article</div>';
}

function save_publications() {
  global $publications;
  $json = prettyPrint(json_encode($publications));
  file_put_contents('json/publications.json', $json);
}

function save_events() {
  global $events;
  $json = prettyPrint(json_encode($events));
  file_put_contents('json/events.json', $json);
}

function new_event() {
  $event = array();
  $event['date'] = $_POST['date'];
  $event['content'] = $_POST['content'];
  global $events;
  array_unshift($events, $event);
  save_events();
  echo '<div class="message">Saved new event</div>';
}

$art = array(); // article to populate 
$edit_art = false;

if (isset($_SESSION['logged_in'])) {
  if (isset($_GET['logout'])) {
    if (session_id()!='') {
      session_destroy();
    }
    logout('You have successfully logged out.');  
  } elseif ($_SERVER['REMOTE_ADDR'] != $_SESSION['ip']) {
    logout('You have been automatically logged out since your IP has changed.');
  } elseif (time() - $_SESSION['timestamp'] > TIMEOUT) {
    logout('Session timed out.');
  } else {
    
    $_SESSION['timestamp'] = time();
    
    if (isset($_POST['new_event'])) {
      new_event();
    
    } elseif (isset($_POST['new_announcement'])) {
    
    } elseif (isset($_POST['new_article'])) {
      new_article();
    } elseif (isset($_GET['edit_article'])) {
      $order = $_GET['order'];
      global $publications;
      foreach ($publications['articles'] as $idx => $article) {
        if ($article['order'] == $order) {
          $art = $article;
          $edit_art = true;
        }
      }
    }
  }  
} else {
  if (isset($_POST['login'])) {
    $ip = bcrypt_decrypt($_POST['a'], $key, $iv);
    if ($_SERVER['REMOTE_ADDR'] != $ip) die ('bad IP');
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (isset($users[$username])) {
      if (bcrypt_verify($password, $users[$username]['password'])) {
        $_SESSION['logged_in'] = true;
        $_SESSION['timestamp'] = time();
        $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
        echo '<div class="message">Welcome</div>';
      } else {
        display_login_form('Username/password mismatch.');
      }
    } else {
      display_login_form('Username not found.');
    }
  } else {
    display_login_form();
  }
} 

if (isset($_SESSION['logged_in'])) {
  
  $errors = array();
  $warnings = array();
  $files = array('json', 'json/events.json', 'json/announcements.json', 
  'json/links.json', 'json/pages.json', 'json/publications.json', 'json/tabs.json');
  foreach ($files as $file) {
    if (!is_writable($file)) {
      if (chmod($file, 0755)) {
        $warnings[] = "$file was not writable, but chmod() was successful.";
      } else {
        $errors[] = "$file was not writable, and chmod() failed.";
      }
    }
  }
  
  if (count($warnings)) {
    echo '<div class="status yellow"><h2>Warnings</h2>'.EOL;
    foreach($warnings as $warning) {
      echo '<p>'.$warning.'</p>'.EOL;
    }
    echo '</div>'.EOL;
  }
  if (count($errors)) {
    echo '<div class="status red"><h2>Errors</h2>'.EOL;
    foreach($errors as $error) {
      echo '<p>'.$error.'</p>'.EOL;
    }
    echo '</div>'.EOL;
  }
  
?>
  
<div class="sidebar-forms">
<form action="admin" method="post">
<fieldset>
<legend>Create Announcement</legend>
<label for="date">Date</label>
<input type="text" name="date" value="<?php echo date('M. j');?>" /><br />
<label for="content">Content</label>
<textarea name="content">
</textarea><br />
<input type="hidden" name="new_announcement" value="true" />
<label></label>
<input type="submit" value="Create" class="btn" />
</fieldset>
</form>
<form action="admin" method="post">
<fieldset>
<legend>Create Upcoming Event</legend>
<label for="date">Date</label>
<input type="text" autocomplete="off" name="date" value="<?php echo date('M. j');?>" /><br />
<label for="content">Content</label>
<textarea name="content">
</textarea><br />
<input type="hidden" name="new_event" value="true" />
<label></label>
<input type="submit" value="Create" class="btn" />
</fieldset>
</form>
</div>

<div id="articles-forms">
<form action="admin" method="post" id="article">

<?php
if($edit_art) {
  echo '<fieldset class="articles"><legend>Edit Article</legend>';
  echo '<input type="hidden" name="update_article" value="true"/>';
} else {
  $art = array();
  $art['month'] = date('M');
  $art['year'] = date('Y');
  $art['order'] = intval($publications['articles'][0]['order']) + 1;
  echo '<fieldset class="articles"><legend>Create Article</legend>';
  echo '<input type="hidden" name="new_article" value="true"/>';
}
?>
<label for="title">Order / UID</label>
<input type="text" autocomplete="off" name="order" value="<?=$art['order'];?>" class="w24" /><br />
<label for="title">Title</label>
<input type="text" autocomplete="off" name="title" value="<?=$art['title'];?>" class="w24" /><br />
<label for="authors">Authors (1-8)</label>
<input type="text" autocomplete="off" name="author-1" value="<?=$art['authors'][0];?>" class="author" />
<input type="text" autocomplete="off" name="author-2" value="<?=$art['authors'][1];?>" class="author" />
<br /><label>&nbsp;</label>
<input type="text" autocomplete="off" name="author-3" value="<?=$art['authors'][2];?>" class="author" />
<input type="text" autocomplete="off" name="author-4" value="<?=$art['authors'][3];?>" class="author" />
<br /><label>&nbsp;</label>
<input type="text" autocomplete="off" name="author-5" value="<?=$art['authors'][4];?>" class="author" />
<input type="text" autocomplete="off" name="author-6" value="<?=$art['authors'][5];?>" class="author" />
<br /><label>&nbsp;</label>
<input type="text" autocomplete="off" name="author-7" value="<?=$art['authors'][6];?>" class="author" />
<input type="text" autocomplete="off" name="author-8" value="<?=$art['authors'][7];?>" class="author" style="margin-bottom:0.8em" />
<br />
<label for="journal">Journal</label>
<input type="text" autocomplete="off" name="journal" id="journal-textbox" value="<?=$art['journal'];?>" class="w24" /><br />
<label for="month">mon. yr. vol. num.</label>
<select name="month" class="month">
<?php
$months = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
foreach ($months as $month) {
  if ($month == date('M',strtotime($art['month']))) {
    echo "<option value=\"$month\" selected=\"selected\">$month</option>";
  } else { 
    echo "<option value=\"$month\">$month</option>";
  }
}
?>
</select>
<input type="text" autocomplete="off" name="year" value="<?=$art['year'];?>" class="w4" />
<input type="text" autocomplete="off" name="volume" value="<?=$art['volume'];?>" class="w3" />
<input type="text" autocomplete="off" name="number" value="<?=$art['number'];?>" class="w3" />
<label style="width: 4em;">pp.</label>
<input type="text" autocomplete="off" name="pages" value="<?=$art['pages'];?>" class="w7" /><br />
<label for="keywords">Keywords</label>
<input type="text" autocomplete="off" name="keywords" value="<?=$art['keywords'];?>" class="w24" /><br />
<label for="thumbnail">Thumbnail, DOI</label>
<input type="text" autocomplete="off" name="thumbnail" value="<?=$art['thumbnail'];?>" class="w7" />
<input type="text" autocomplete="off" name="doi" value="<?=$art['doi'];?>" class="" /><br />
<label for="fulltext">Fulltext URL</label>
<input type="text" autocomplete="off" name="fulltext" value="<?=$art['fulltext'];?>" class="w24" /><br />
<label for="abstract">Abstract</label>
<textarea name="abstract" class="w24" ><?=$art['abstract'];?></textarea><br />
<label for="comments">Comments</label>
<input type="text" name="comments" class="w24" value="<?=$art['comments'];?>" ><br />
<label></label>
<?php
if($edit_art) {
  echo '<input type="submit" value="Update" class="btn" />';
} else {
  echo '<input type="submit" value="Create" class="btn" />';
}
?>
</fieldset>

<div id="articles-container">
<table id="articles"> 
  <tr><td rowspan="2" colspan="2" style="font-size:120%; font-weight: bold; text-align:center;"><a href="admin#article">New article entry</a></td>
    <td</td></tr>
    <tr></tr>
<?php
foreach ($publications['articles'] as $index => $article) {
  $authors = implode(', ', $article['authors']);
  $authors = substr($authors, 0, 50) . ((strlen($authors) > 50) ? '...' : '');
  $title = substr($article['title'], 0, 50) . '...';
  $order = $article['order'];
  $edit_link = 'edit-article-'.$order.'#article';
  $edit = '<a class="article-pencil" href="'.$edit_link.'"><i class="icon-pencil">&nbsp;</i></a>'.EOL;
  printf('<tr><td class="order">%s</td><td class="authors">%s</td></tr>
  <tr><td class="edit">'.$edit.'</td><td class="title">%s</td></tr>',
  $order, $authors, $title);
}
?>
</table>
</div>

</form>
</div>

<?php
}

$content = ob_get_contents();
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
    if (count($errors) + count($warnings) == 0) {
      echo '<div class="status green"><p>File permissions OK</p></div>'.EOL;
    }
    ?>
    <a href="home" class="home-button" >Home</a>
    <?php if (isset($_SESSION['logged_in'])) { ?>
      <a href="logout" class="logout-button" >Logout</a>
    <?php } ?>
  </div>
  
<div id="content-wrap" class="clearfix">
<?php echo $content; ?>  

</div>
<script>

$(document).ready(function() {
  $('div').addClass('clearfix');
  $('div.message').delay(1000).fadeOut(500);
  //$('div.green').delay(500).fadeOut(500);

});



var authors = [ <?php $authors = get_article_authors(); echo "'".implode("','",$authors)."'"; ?> ]; 
var journals = [ <?php $journals = get_article_journals(); echo "'".implode("','",$journals)."'"; ?> ];
$(function() {
  $( "#journal-textbox" ).autocomplete({ source: journals });
  $( "input.author" ).autocomplete({ source: authors });
});
</script>
</body>
</html>