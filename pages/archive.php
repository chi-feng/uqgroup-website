<?php if (!defined('INCLUDE_GUARD')) { header("HTTP/1.0 403 Forbidden"); die(); } ?>

<h2>Annoucement Archive</h2>

<?php
foreach ($announcements as $index => $announcement) {
  if ($index < 5) {
    printf("          <p><strong>%s</strong><br />%s</p>\n",
      $announcement['date'], $announcement['content']);
  }
}
?>     
  