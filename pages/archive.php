<?php if (!defined('INCLUDE_GUARD')) { header("HTTP/1.0 403 Forbidden"); die(); } ?>

<h2>Archives</h2>

<div class="col-1-2">
<h3>Announcements</h3>
<?php
foreach ($announcements as $index => $announcement) {
  printf("          <p><strong>%s</strong><br />%s</p>\n",
    $announcement['date'], $announcement['content']);
}
?>
</div>

<div class="col-2-2">
<h3>Events</h3>
<?php
$all_events = get_upcoming_events(-1);
echo $all_events; 
?>     
</div>

</script>
  