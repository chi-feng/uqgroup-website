<?php
$template = Template::getInstance();
$template->title = 'Announcement Archives';
?>
<h3>Announcements</h3>
<?php
$announcements = json_decode(file_get_contents('json/announcements.json'),true);
foreach ($announcements as $index => $announcement) {
  printf("<p><strong>%s</strong><br />%s</p>\n",
    $announcement['date'], $announcement['content']);
}
?>