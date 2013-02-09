<?php if (!defined('INCLUDE_GUARD')) { header("HTTP/1.0 403 Forbidden"); die(); } 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>UQGroup - <?=$t['title'];?></title> 
  <link href="css/screen.css" rel="stylesheet" type="text/css" media="screen" />
  <link href='http://fonts.googleapis.com/css?family=Titillium+Web:300' rel='stylesheet' type='text/css'>
  <link href="http://netdna.bootstrapcdn.com/font-awesome/3.0/css/font-awesome.css"  rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
  <script type="text/javascript" src="js/uqgroup.js"></script>
  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  <link rel="shortcut icon" href="favicon.ico" />  
</head>
<body>
<div id="header-wrap">
  <div id="header" class="clearfix">
    <div id="title">
      <h1><a href="home">Uncertainty Quantification Group</a></h1>
      <h2><a href="http://mit.edu">Massuchusetts Institute of Technology</a></h2>
    </div>
  </div>
</div>
<div id="nav-wrap" class="clearfix">
  <div id="nav" class="clearfix">
    <ul id="navbar">
      
      <?php
      foreach ($tabs as $key => $value) {
        $active = ($pages[$page]['tab'] == $key) ? ' class="active"' : ''; 
        printf("<li><a href=\"%s\"%s>%s</a></li>\n", $key, $active, $value['name']);
      }
      ?>
      
      <a class="totop" onclick="$('html, body').animate({scrollTop:0}, 500);"><i class="icon-circle-arrow-up"></i></a>
    </ul>
  </div>
</div>
<div id="content-wrap" class="clearfix">
<div id="content" class="column">
  
<?php echo $t['content']; ?>
  
</div> <!-- content -->
<div id="sidebar-wrap">
  <div id="sidebar">
    <div class="sidebar-box">
      <h2>Announcements</h2>
      <div class="sidebar-content">
        
<?php
foreach ($announcements as $index => $announcement) {
  if ($index < 5) {
    printf("<p><strong>%s</strong><br />%s</p>\n",
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
        
<?php echo get_upcoming_events(4); ?>

      <p><a href="archive">More</a></p>
      </div>
    </div>
    <div class="sidebar-box">
      <h2>Links</h2>
      <div class="sidebar-content">
        <ul class="links">
          
<?php
foreach ($links as $link) {
printf("<li><a href=\"%s\">%s</a></li>\n",
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
</body>
</html>
