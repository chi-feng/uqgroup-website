<?php 

session_start();

date_default_timezone_set('America/New_York');

define('INCLUDE_GUARD', true);
define('SESSION_TIMEOUT', 6000);

require_once('includes/orm.php');
require_once('includes/Bcrypt.php');

$key = 'herpderp'; 
$iv = '1234567812345678'; 
// passwords salted and hashed, see implementation in includes/Bcrypt.php
$users = array(
  'chifeng' => array('password' => '$2a$10$es5UK4mYTwoaTkgSXXLEfOg6RcbcYa.FZHFCzGFWvhxbFxzyHeLEm'),
  'ymarz' => array('password' => '$2a$10$zatTt1uoQqrYoFDg16GVsuA2UkQj7OFwnnUB2Ga.rxd39OWoy4MWi'),
);

$t = array(); 

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
      header('Location: admin.php');
    } else {
      $t['content'] .= login_form('Username/password mismatch.');
      finish();
    }
  } else {
    $t['content'] .= login_form('User not found.');
    finish();
  }
}

if (!$_SESSION['logged_in']) {
  $t['content'] .= login_form();
  finish();
}

function logout($msg) {
  if (session_id() != '') {
    unset($_SESSION['logged_in']);
    session_destroy();
  }
  global $t;
  $t['content'] .= login_form($msg);
  finish();
}

if (isset($_GET['logout'])) {
  logout();
}

if ($_SERVER['REMOTE_ADDR'] != $_SESSION['ip']) {
  logout('Your session was invalid.');
} elseif (time() - $_SESSION['timestamp'] > SESSION_TIMEOUT) {
  logout('Your session has timed out.');
} else {
  
}
// we are logged in and the session is okay and we aren't trying to log out
  
$_SESSION['timestamp'] = time();

if (isset($_GET['view_announcements'])) {
  $announcement = new Announcement(array());
  $t['content'] .= $announcement->viewall();
  finish();
}
if (isset($_GET['create_announcement'])) {
  $announcement = new Announcement(array('date'=>date('M j, Y')));
  $t['content'] .= $announcement->create();
  finish();
}
if (isset($_GET['edit_announcement'])) {
  $announcement = new Announcement('id', $_REQUEST['id']);
  $t['content'] .= $announcement->edit();
  finish();
}
if (isset($_POST['update_announcement'])) {
  $announcement = new Announcement('post');
  $announcement->update('id', $_REQUEST['id']);
  header('Location: admin.php?view_announcements');
}
if (isset($_POST['insert_announcement'])) {
  $announcement = new Announcement('post');
  $announcement->insert_front();
  header('Location: admin.php?view_announcements');
}
if (isset($_REQUEST['delete_announcement'])) {
  $announcement = new Announcement(array());
  $announcement->delete('id', $_REQUEST['id']);
  header('Location: admin.php?view_announcements');
}

if (isset($_GET['view_articles'])) {
  $article = new Article(array());
  $t['content'] .= $article->viewall();
  finish();
}
if (isset($_GET['create_article'])) {
  $article = new Article(array());
  $article->set('order', $article->get_max_order()+1);
  $t['content'] .= $article->create();
  finish();
}
if (isset($_GET['edit_article'])) {
  $article = new Article('id', $_REQUEST['id']);
  $t['content'] .= $article->edit();
  finish();
}
if (isset($_POST['update_article'])) {
  $article = new Article('post');
  $article->update('id', $_REQUEST['id']);
  header('Location: admin.php?view_articles');
  die();
}
if (isset($_POST['insert_article'])) {
  $article = new Article('post');
  $article->insert_front();
  header('Location: admin.php?view_articles');
}
if (isset($_REQUEST['delete_article'])) {
  $article = new Article(array());
  $article->delete('id', $_REQUEST['id']);
  header('Location: admin.php?view_articles');
}
if (isset($_REQUEST['sort_articles'])) { 
  $article = new Article(array());
  $article->sort('descending');
  header('Location: admin.php?view_articles');
}


if (isset($_GET['view_events'])) {
  $event = new Event(array());
  $t['content'] .= $event->viewall();
  finish();
}
if (isset($_GET['create_event'])) {
  $event = new Event(array());
  $event->set('start_date', date('M d, Y'));
  $event->set('end_date', date('M d, Y'));
  $t['content'] .= $event->create();
  finish();
}
if (isset($_GET['edit_event'])) {
  $event = new Event('id', $_REQUEST['id']);
  $t['content'] .= $event->edit();
  finish();
}
if (isset($_POST['update_event'])) {
  $event = new Event('post');
  $event->update('id', $_REQUEST['id']);
  header('Location: admin.php?view_events');
}
if (isset($_POST['insert_event'])) {
  $event = new Event('post');
  $event->insert_front();
  header('Location: admin.php?view_events');
}
if (isset($_REQUEST['delete_event'])) {
  $event = new Event(array());
  $event->delete('id', $_REQUEST['id']);
  header('Location: admin.php?view_events');
}
if (isset($_REQUEST['sort_events'])) { 
  $event = new Event(array());
  $event->sort('descending');
  header('Location: admin.php?view_events');
}

dashboard();

function dashboard() {
  global $t;
  $json_files = glob('json/*.json');
  $t['content'] .= '<h2>Administration Dashboard</h2>';
  $t['content'] .= '<div class="col-2-2">';
  $t['content'] .= '<h3>JSON Permissions</h3>';
  $t['content'] .= '<table class="status json-status">';
  $t['content'] .= '<tr><th>File</th><th>Perms</th><th>Read</th><th>Write</th></tr>';
  foreach (glob('json/*.json') as $file) {
    $readable = (is_readable($file)) ? '<span class="green" />OK</span>' : '<span class="red">FAIL</span>';
    $writable = (is_writable($file)) ? '<span class="green" />OK</span>' : '<span class="red">FAIL</span>';
    $perms = substr(sprintf('%o', fileperms($file)), -4);
    $t['content'] .= sprintf('<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>',
      $file, $perms,$readable, $writable);
  }
  $t['content'] .= '</table>';
  $t['content'] .= '</div>';
  $t['content'] .= '<div class="col-1-2">';
  $t['content'] .= '<h3>Page Status</h3>';
  $t['content'] .= '<table class="status page-status">';
  $t['content'] .= '<tr><th>File</th><th>Page</th><th>Exists</th></tr>';
  foreach (json_decode(file_get_contents('json/pages.json'), true) as $page => $details) {
    $file = "pages/$page.php";
    $title = $details['title'];
    $exists = file_exists("pages/$page.php") ? '<span class="green" />OK</span>' : '<span class="red">FAIL</span>';
    $t['content'] .= sprintf('<tr><td>%s</td><td>%s</td><td>%s</td></tr>',
      $file, $title, $exists);
  }
  $t['content'] .= '</table>';
  $t['content'] .= '</div><br style="clear: both;" />';
  $t['content'] .= '<h3>Quick Links</h3>';
  $t['content'] .= '<ul><li><a href="https://www.google.com/analytics/web/?hl=en&pli=1#report/visitors-overview/a38300402w66904103p68823002/">Google Analytics</a></li>';
  $t['content'] .= '<ul><li><a href="https://github.com/chi-feng/uqgroup-website">GitHub Repository</a></li>';
}

function finish() {
  global $t; 
  include('includes/admin_header.php');
  echo $t['content'];
  include('includes/admin_footer.php');  
  die();
}

function login_form($message='') {
  global $key, $iv;
  $client_ip = bcrypt_encrypt($_SERVER['REMOTE_ADDR'], $key, $iv);
  $hidden_fields = sprintf('<input type="hidden" name="a" value="%s">', $client_ip);
  $return = '';
  if (!empty($message)) {
    $return .= '<div class="message">' . $message .'</div>';
  }
  $return .= '<form action="admin" method="post" class="centered">
  <fieldset>
  <legend>Login</legend>
  <label for="username">Username</label><input type="text" name="username" autocomplete="off" /><br />
  <label for="username">Password</label><input type="password" name="password" autocomplete="off" /><br />
  ' . $hidden_fields . '<input type="hidden" name="login" value="true" />
  <label></label><input type="submit" value="Login" class="btn" />
  </form>';
  return $return;
}

finish();

?>