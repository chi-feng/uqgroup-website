<?php if (!defined('INCLUDE_GUARD')) { header("HTTP/1.0 403 Forbidden"); die(); } ?>

</div> <!-- content -->

<div id="sidebar-wrap">
  <div id="sidebar">
    <div class="sidebar-box">
      <h2>Announcements</h2>
      <div class="sidebar-content">
<?php
foreach ($announcements as $index => $announcement) {
  if ($index < 5) {
    printf("          <p><strong>%s</strong><br />%s</p>\n",
      $announcement['date'], $announcement['content']);
  }
}
?>
      <p><a href="archive">More</a></p>
      </div>
    </div>
    <div class="sidebar-box">
      <h2>Upcoming Events</h2>
      <div class="sidebar-content">
<?php
foreach ($events as $index => $event) {
  if ($index < 5) {
    $start = '';
    $end = '';
    $trp = 'false';
    if (!empty($event['start_time']) && !empty($event['end_time'])) {
      $start_time = strtotime($event['start_date'].' '.$event['start_time']);
      $end_time = strtotime($event['end_date'].' '.$event['end_time']);
      $start = gmdate("Ymd\THis\Z", $start_time);
      $end = gmdate("Ymd\THis\Z", $end_time);
      $trp = 'true';
    } else if (!empty($event['start_date']) && !empty($event['end_date'])) {
      $start_time = strtotime($event['start_date']);
      $end_time = strtotime($event['end_date']) + 24*3600;
      $start = gmdate("Ymd", $start_time);
      $end = gmdate("Ymd", $end_time);
    } else {
      $start_time = strtotime($event['start_date']);
      $end_time = strtotime($event['start_date']) + 24*3600;
      $start = gmdate("Ymd", $start_time);
      $end = gmdate("Ymd", $end_time);
    }
    $link = '<a target="_blank" href="http://www.google.com/calendar/event?action=TEMPLATE&text='.urlencode($event['name']).'&dates='.$start.'/'.$end.'&location='.urlencode($event['location']).'&details='.urlencode($event['content']).'&trp='.$trp.'"><i class="icon-calendar"></i></a>';
    $daterange = (!empty($event['end_date']) && $event['end_date'] != $event['start_date']) ? $event['start_date'].' - '.$event['end_date'] : $event['start_date'];
    printf("          <p><strong>%s</strong><br />%s %s</p>\n",
      $daterange, $event['name'], $link);
  }
}
?>      
      <p><a href="archive">More</a></p>
      </div>
    </div>
    <div class="sidebar-box">
      <h2>Links</h2>
      <div class="sidebar-content">
        <ul class="links">
<?php
foreach ($links as $link) {
printf("            <li><a href=\"%s\">%s</a></li>\n",
  $link['href'], $link['name']);
}
?>
        </ul>
      </div>
    </div>    
  </div>
</div> 

</div> <!-- content-wrap -->
<div id="footer-wrap">
<div id="footer" class="clearfix">
  
  <div class="logos-wrapper">
  <ul class="logos">
    <li><a href="http://mit.edu" target="_new"><img src="images/mitlogo.png" alt="cce" width="200" /></a></li>
    <li><a href="http://aeroastro.mit.edu" target="_new"><img src="images/aeroastro.png" alt="aeroastro" width="180" /></a></li>
    <li><a href="http://acdl.mit.edu" target="_new"><img src="images/acdl.png" alt="acdl" width="100" /></a></li>
    <li><a href="http://computationalengineering.mit.edu" target="_new"><img src="images/cce.png" alt="cce" width="200" /></a></li>
  </ul>
  </div>
  
  <div class="contact">
    <div class="youssef">
      <h4>Contact Information</h4>
      <p><a href="http://web.mit.edu/aeroastro/people/marzouk.html" target="_new"><strong>Youssef Marzouk</strong></a></p>
      <p>Class of 1942 Associate Professor <br /> of Aeronautics and Astronautics</p>
      <p><i class="icon-envelope"></i> ymarz (at) mit.edu</p>
      <p><i class="icon-phone"></i> (617) 253-1337</p>
      </p>
      <p><i class="icon-map-marker"></i> 77 Massachusetts Ave, Room <a href="http://whereis.mit.edu/?go=33" target="_new">33</a>-217<br />
       <i>&nbsp;</i> Cambridge, MA 02139
      </p>
    </div>
    <div class="admin">
      <h4>&nbsp;</h4>
      <p><strong>Sophia Hasenfus</strong></p>      
      <p>Administrative Assistant<br />&nbsp;</p>
      <p><i class="icon-envelope"></i> shasen (at) mit.edu</p>
      <p><i class="icon-phone"></i> (617) 252-1536</p>
      </p>
    </div>
  </div>
  <br style="clear: both" />
  <div class="footer-bottom clearfix">
    <div class="designed-by">
      Design by <a href="http://chifeng.scripts.mit.edu/">Chi Feng</a>
    </div>
    <div class="copyright">
      Copyright &copy;2013, MIT Uncertainty Quantification Group.  
    </div>
  </div>
</div>
</div>
<?php
if ($use_mathjax) {
?>
<script type="text/x-mathjax-config">
MathJax.Hub.Config({ tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]} });
</script>
<?php
}
?>
<!-- 
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-38300402-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
-->
</body>
</html>
