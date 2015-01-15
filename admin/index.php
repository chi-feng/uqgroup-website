<?php 

date_default_timezone_set('America/New_York');

require_once('orm.php');

/*
$client_name = $_SERVER["SSL_CLIENT_S_DN_CN"];
$remote_addr = $_SERVER["REMOTE_ADDR"];
$ssl_verify = $_SERVER["SSL_CLIENT_VERIFY"];

if ($ssl_verify != "SUCCESS") {
  die ('SSL verification failed');
}
*/

$t = array(); 

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
  header('Location: index.php?view_announcements');
}
if (isset($_POST['insert_announcement'])) {
  $announcement = new Announcement('post');
  $announcement->insert_front();
  header('Location: index.php?view_announcements');
}
if (isset($_REQUEST['delete_announcement'])) {
  $announcement = new Announcement(array());
  $announcement->delete('id', $_REQUEST['id']);
  header('Location: index.php?view_announcements');
}


if (isset($_GET['view_people'])) {
  $person = new Person(array());
  $t['content'] .= $person->viewall();
  finish();
}
if (isset($_GET['create_person'])) {
  $person = new Person(array('date'=>date('M j, Y')));
  $t['content'] .= $person->create();
  finish();
}
if (isset($_GET['edit_person'])) {
  $person = new Person('id', $_REQUEST['id']);
  $t['content'] .= $person->edit();
  finish();
}
if (isset($_POST['update_person'])) {
  $person = new Person('post');
  $person->update('id', $_REQUEST['id']);
  $person = new Person(array());
  $person->sort('descending');
  header('Location: index.php?view_people');
}
if (isset($_POST['insert_person'])) {
  $person = new Person('post');
  $person->insert_front();
  $person = new Person(array());
  $person->sort('descending');
  header('Location: index.php?view_people');
}
if (isset($_REQUEST['delete_person'])) {
  $person = new Person(array());
  $person->delete('id', $_REQUEST['id']);
  header('Location: index.php?view_people');
}
if (isset($_REQUEST['sort_people'])) { 
  $person = new Person(array());
  $person->sort('descending');
  header('Location: index.php?view_people');
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
  header('Location: index.php?view_articles');
  die();
}
if (isset($_POST['insert_article'])) {
  $article = new Article('post');
  $article->insert_front();
  header('Location: index.php?view_articles');
}
if (isset($_REQUEST['delete_article'])) {
  $article = new Article(array());
  $article->delete('id', $_REQUEST['id']);
  header('Location: index.php?view_articles');
}
if (isset($_REQUEST['sort_articles'])) { 
  $article = new Article(array());
  $article->sort('descending');
  header('Location: index.php?view_articles');
}


if (isset($_GET['view_conferences'])) {
  $conference = new Conference(array());
  $t['content'] .= $conference->viewall();
  finish();
}
if (isset($_GET['create_conference'])) {
  $conference = new Conference(array());
  $conference->set('order', $conference->get_max_order()+1);
  $t['content'] .= $conference->create();
  finish();
}
if (isset($_GET['edit_conference'])) {
  $conference = new Conference('id', $_REQUEST['id']);
  $t['content'] .= $conference->edit();
  finish();
}
if (isset($_POST['update_conference'])) {
  $conference = new Conference('post');
  $conference->update('id', $_REQUEST['id']);
  header('Location: index.php?view_conferences');
  die();
}
if (isset($_POST['insert_conference'])) {
  $conference = new Conference('post');
  $conference->insert_front();
  header('Location: index.php?view_conferences');
}
if (isset($_REQUEST['delete_conference'])) {
  $conference = new Conference(array());
  $conference->delete('id', $_REQUEST['id']);
  header('Location: index.php?view_conferences');
}
if (isset($_REQUEST['sort_conferences'])) { 
  $conference = new Conference(array());
  $conference->sort('descending');
  header('Location: index.php?view_conferences');
}

dashboard();

function dashboard() {
  global $t;
  $json_files = glob('../json/*.json');
  $t['content'] .= '<h2>Administration Dashboard</h2>';
  $t['content'] .= '<div class="col-1-2">';
  $t['content'] .= '<h3>JSON Permissions</h3>';
  $t['content'] .= '<table class="status json-status">';
  $t['content'] .= '<tr><th>File</th><th>Perms</th><th>Read</th><th>Write</th></tr>';
  foreach (glob('../json/*.json') as $file) {
    $readable = (is_readable($file)) ? '<td class="green"><i class="icon-ok"></i></td>' : '<td class="red"><i class="icon-remove"></i></td>';
    $writable = (is_writable($file)) ? '<td class="green"><i class="icon-ok"></i></td>' : '<td class="red"><i class="icon-remove"></i></td>';
    $perms = substr(sprintf('%o', fileperms($file)), -4);
    if ($perms != '0777') {
      $perms = '<td class="red"><i class="icon-warning-sign"></i> '.$perms.'</td>';
    } else {
      $perms = '<td class="green">'.$perms.'</td>';
    }
    $t['content'] .= sprintf('<tr><td>%s</td>%s%s%s</tr>',
      $file, $perms,$readable, $writable);
  }
  $t['content'] .= '</table>';
  $t['content'] .= '</div>';
  $t['content'] .= '<br style="clear: both;" />';
  $t['content'] .= '<h3>Quick Links</h3>';
  $t['content'] .= '<ul class="links"><li><a href="https://www.google.com/analytics/web/?hl=en&pli=1#report/visitors-overview/a38300402w66904103p68823002/">Google Analytics</a></li>';
  $t['content'] .= '<li><a href="https://github.com/chi-feng/uqgroup-website">GitHub Repository</a></li></ul>';
}

function finish() {
  include('template.php');
  die();
}


finish();

?>