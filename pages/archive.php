<?php if (!defined('INCLUDE_GUARD')) { header("HTTP/1.0 403 Forbidden"); die(); } ?>

<h2>Archives</h2>

<div class="col-1-2">
<h3>Announcements</h3>
<?php
foreach ($articles as $index => $article) {
  printf("  <p><strong>%s</strong><br />%s</p>\n", $article['date'], $article['content']);
}
?>     
</div>

<div class="col-2-2">
<h3>Events</h3>
<?php
foreach ($events as $index => $event) {
  printf("  <p><strong>%s</strong><br />%s</p>\n", $event['date'], $event['content']);
}
?>     
</div>
  