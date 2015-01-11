<?php
$template = Template::getInstance();
$template->title = 'Conference Publications';
$template->tab = 'Publications';
?>
<div id="publication-switcher" class="clearfix">
  <h3 id="journal-publications"><a href="/publications/articles">Journal Articles</a></h3>
  <h3 id="conference-publications" class="active"><a href="/publications/conferences">Conference Publications</a></h3>
  <h3 id="book-chapters"><a href="/publications/books-other">Books &amp; Other Press</a></h3>
</div>

<div id="conferences-wrapper">
<div id="conferences">
<?php
$conferences = json_decode(file_get_contents('json/conferences.json'), true);
foreach ($conferences as $index => $conference) {
  echo render_conference($index, $conference);
}
?>
</div>
</div>
