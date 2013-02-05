<?php if (!defined('INCLUDE_GUARD')) { header("HTTP/1.0 403 Forbidden"); die(); } 

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
  <label for="username">Username</label><input type="text" name="username" autocomplete="off" /><br />
  <label for="username">Password</label><input type="password" name="password" autocomplete="off" /><br />
  ' . $hidden_fields . '<input type="hidden" name="login" value="true" />
  <label></label> <input type="submit" value="Login" class="btn" />
  </form>';
}

function logout($message) {
  unset($_SESSION['logged_in']);
  if (session_id()!='')
    session_destroy();
  display_login_form($message);
}

function new_article() {
  global $publications;
  $article = array();
  $fields = array('order','title','fulltext','journal','year','month','volume',
    'number','pages','keywords','thumbnail','doi','abstract','comments');
  foreach ($fields as $field) {
    $article[$field] = $_POST[$field];
  }
  $authors = array();
  for($i=1;$i<=8;$i++) {
    $postvar = $_POST['author-'.strval($i)];
    if (!empty($postvar))
      $authors[] = $postvar;
  }
  $article['authors'] = $authors;
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
  global $events;
  $event = array();
  $event['date'] = $_POST['date'];
  $event['content'] = $_POST['content'];
  array_unshift($events, $event);
  save_events();
  echo '<div class="message">Saved new event</div>';
}


function save_announcements() {
  global $announcements;
  $json = prettyPrint(json_encode($announcements));
  file_put_contents('json/announcements.json', $json);
}

function new_announcement() {
  global $announcements;
  $announcement = array();
  $announcement['date'] = $_POST['date'];
  $announcement['content'] = $_POST['content'];
  array_unshift($announcements, $announcement);
  save_announcements();
  echo '<div class="message">Saved new announcement</div>';
}

function edit_article() {
  global $publications, $template;
  $order = $_GET['order'];
  foreach ($publications['articles'] as $idx => $article) {
    if ($article['order'] == $order) {
      $template['article'] = $article;
      $template['edit_article'] = true;
      break;
    }
  }
}

function check_permissions() {
  
  global $errors, $wranings;
  
  $files = array('json', 'json/events.json', 'json/announcements.json', 
    'json/links.json', 'json/pages.json', 'json/publications.json', 
    'json/tabs.json');
    
  foreach ($files as $file) {
    if (!is_writable($file)) {
      if (chmod($file, 0755))
        $warnings[] = "$file was not writable, but chmod() was successful.";
      else
        $errors[] = "$file was not writable, and chmod() failed.";
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
}

function get_sidebar_forms() {
  echo '<div class="sidebar-forms">
  <form action="admin" method="post">
  <fieldset>
  <legend>Create Announcement</legend>
  <label for="date">Date</label>
  <input type="text" name="date" value="'.date('M. j').'" /><br />
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
  <input type="text" autocomplete="off" name="date" value="'.date('M. j').'" /><br />
  <label for="content">Content</label>
  <textarea name="content">
  </textarea><br />
  <input type="hidden" name="new_event" value="true" />
  <label></label>
  <input type="submit" value="Create" class="btn" />
  </fieldset>
  </form>
  </div>';
}

function article_cmp($a, $b) {
  return ($a['order'] > $b['order']) ? -1 : 1;
}

function sort_articles() {
  global $publications;
  usort($publications['articles'], 'article_cmp');
}
 
function update_article() {
  global $publications;
  $original_order = $_POST['original_order'];
  // check that original publication exists 
  $found = false;
  foreach ($publications['articles'] as $idx => $original) {
    if ($original['order'] == $original_order) {
      $found = true; 
      break;
    }
  }
  if ($found) {
    $article = array();
    $fields = array('order','title','fulltext','journal','year','month','volume',
      'number','pages','keywords','thumbnail','doi','abstract','comments');
    foreach ($fields as $field) {
      $article[$field] = $_POST[$field];
    }
    $authors = array();
    for($i=1;$i<=8;$i++) {
      $postvar = $_POST['author-'.strval($i)];
      if (!empty($postvar))
        $authors[] = $postvar;
    }
    $article['authors'] = $authors;
    $publications['articles'][$idx] = $article;
    save_publications();
    echo '<div class="message">Article has been updated</div>';
  } else {
    global $errors;
    $errors[] = "Could not find article with order '$original_order'";
  }
  
}

function get_articles_forms() {
  global $template, $publications;
  ?>
  <div id="articles-forms">
  <form action="admin" method="post" id="article">
  <?php
  if ($template['edit_article']) {
    echo '<fieldset class="articles"><legend>Edit Article</legend>';
    echo '<input type="hidden" name="update_article" value="true"/>';
    echo '<input type="hidden" name="original_order" value="'.$template['article']['order'].'"/>';
  } else {
    $template['article'] = array();
    $template['article']['month'] = date('M');
    $template['article']['year'] = date('Y');
    $template['article']['order'] = intval($publications['articles'][0]['order']) + 1;
    echo '<fieldset class="articles"><legend>Create Article</legend>';
    echo '<input type="hidden" name="new_article" value="true"/>';
  }
  ?>
  <label for="title">Order / UID</label>
  <input type="text" autocomplete="off" name="order" value="<?=$template['article']['order'];?>" class="w24" /><br />
  <label for="title">Title</label>
  <input type="text" autocomplete="off" name="title" value="<?=$template['article']['title'];?>" class="w24" /><br />
  <label for="authors">Authors (1-8)</label>
  <input type="text" autocomplete="off" name="author-1" value="<?=$template['article']['authors'][0];?>" class="author" />
  <input type="text" autocomplete="off" name="author-2" value="<?=$template['article']['authors'][1];?>" class="author" /><br /><label>&nbsp;</label>
  <input type="text" autocomplete="off" name="author-3" value="<?=$template['article']['authors'][2];?>" class="author" />
  <input type="text" autocomplete="off" name="author-4" value="<?=$template['article']['authors'][3];?>" class="author" /><br /><label>&nbsp;</label>
  <input type="text" autocomplete="off" name="author-5" value="<?=$template['article']['authors'][4];?>" class="author" />
  <input type="text" autocomplete="off" name="author-6" value="<?=$template['article']['authors'][5];?>" class="author" /><br /><label>&nbsp;</label>
  <input type="text" autocomplete="off" name="author-7" value="<?=$template['article']['authors'][6];?>" class="author" />
  <input type="text" autocomplete="off" name="author-8" value="<?=$template['article']['authors'][7];?>" class="author" style="margin-bottom:0.8em" />
  <br />
  <label for="journal">Journal</label>
  <input type="text" autocomplete="off" name="journal" id="journal-textbox" value="<?=$template['article']['journal'];?>" class="w24" /><br />
  <label for="month">mon. yr. vol. num.</label>
  <select name="month" class="month">
  <?php
  $months = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
  foreach ($months as $month) {
    if ($month == date('M', strtotime($template['article']['month']))) {
      echo "<option value=\"$month\" selected=\"selected\">$month</option>";
    } else { 
      echo "<option value=\"$month\">$month</option>";
    }
  }
  ?>
  </select>
  <input type="text" autocomplete="off" name="year" value="<?=$template['article']['year'];?>" class="w4" />
  <input type="text" autocomplete="off" name="volume" value="<?=$template['article']['volume'];?>" class="w3" />
  <input type="text" autocomplete="off" name="number" value="<?=$template['article']['number'];?>" class="w3" />
  <label style="width: 4em;">pp.</label>
  <input type="text" autocomplete="off" name="pages" value="<?=$template['article']['pages'];?>" class="w7" /><br />
  <label for="keywords">Keywords</label>
  <input type="text" autocomplete="off" name="keywords" value="<?=$template['article']['keywords'];?>" class="w24" /><br />
  <label for="thumbnail">Thumbnail, DOI</label>
  <input type="text" autocomplete="off" name="thumbnail" value="<?=$template['article']['thumbnail'];?>" class="w7" />
  <input type="text" autocomplete="off" name="doi" value="<?=$template['article']['doi'];?>" class="" /><br />
  <label for="fulltext">Fulltext URL</label>
  <input type="text" autocomplete="off" name="fulltext" value="<?=$template['article']['fulltext'];?>" class="w24" /><br />
  <label for="abstract">Abstract</label>
  <textarea name="abstract" class="w24" ><?=$template['article']['abstract'];?></textarea><br />
  <label for="comments">Comments</label>
  <input type="text" name="comments" class="w24" value="<?=$template['article']['comments'];?>" ><br />
  <label></label>
  <?php
  if($template['edit_article']) {
    echo '<input type="submit" value="Update" class="btn" />';
  } else {
    echo '<input type="submit" value="Create" class="btn" />';
  }
  ?>
  </fieldset>
  <div id="articles-container">
  <table id="articles"> 
  <tr><td colspan="2" class="create-button">
    <a href="admin#article">New Article</a>
    <a href="sort-articles">Sort Articles</a>
  </td><td</td></tr>
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
?>