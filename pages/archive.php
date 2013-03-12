<?php if (!defined('INCLUDE_GUARD')) { header("HTTP/1.0 403 Forbidden"); die(); } ?>
<div class="col-1-2 archive">
<h3>Announcements</h3>
<?php
foreach ($announcements as $index => $announcement) {
  printf("          <p><strong>%s</strong><br />%s</p>\n",
    $announcement['date'], $announcement['content']);
}
?>
</div>

<div class="col-2-2 archive">
<h3>Upcoming Events</h3>
<?php
$all_events = get_upcoming_events(100);
echo $all_events; 
?>     
<h3>Past Events</h3>
<?php
$past_events = get_past_events();
echo $past_events; 
?>     
</div>

</script>
  