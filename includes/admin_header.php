<?php if (!defined('INCLUDE_GUARD')) { header("HTTP/1.0 403 Forbidden"); die(); } 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <!--<link href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css"  rel="stylesheet" type="text/css" />-->
  <link href='http://fonts.googleapis.com/css?family=Titillium+Web:300' rel='stylesheet' type='text/css'>
  <link href="http://netdna.bootstrapcdn.com/font-awesome/3.0/css/font-awesome.css"  rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
  <script type="text/javascript" src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
  <script type="text/javascript" src="js/admin.js"></script>
  <link rel="stylesheet" type="text/css" href="css/admin.css" media="screen" />
  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  <link rel="shortcut icon" href="favicon.ico" />  
</head>
<body>
  
<div class="menubar">
  <?php if (!isset($_SESSION['logged_in'])) { ?>
  <a class="home-button" href="home">Home</a>  
  <?php } ?>
  <?php if (isset($_SESSION['logged_in'])) { ?>
  <div id="nav"> 
  <ul>
  <li><a href="admin.php"><i class="icon-cog"></i></a>
    <ul>
    <li><a href="admin.php">Dashboard</a></li>
    <li><a href="home">Home</a></li>
    <li><a href="admin.php?logout">Logout</a></li>
    </ul>
  </li>
  <li><a href="admin.php?view_announcements">Announcements</a>
    <ul>
    <li><a href="admin.php?view_announcements">View Announcements</a></li>
    <li><a href="admin.php?create_announcement">Create Announcement</a></li>
    </ul>
  </li>
  <li><a href="admin.php?view_events">Events</a>
    <ul>
    <li><a href="admin.php?view_events">View Events</a></li>
    <li><a href="admin.php?create_event">Create Event</a></li>
    <li><a class="confirm" href="admin.php?sort_events">Sort Events by Date</a></li>
    </ul>
  </li>
  <li><a href="admin.php?view_articles">Articles</a>
    <ul>
    <li><a href="admin.php?view_articles">View Articles</a></li>
    <li><a href="admin.php?create_article">Create Article</a></li>
    <li><a class="confirm" href="admin.php?sort_articles">Sort Articles by Order ID</a></li>
    </ul>
  </li>
  <!--
  <li><a>Conferences</a>
    <ul>
    <li><a href="admin.php?view_conferences">View Conferences</a></li>
    <li><a href="admin.php?create_conferences">Create Conference</a></li>
    <li><a class="confirm" href="admin.php?sort_conferences">Sort Conferences</a></li>
    </ul>
  </li>
  -->
  </ul>
  </div>
  <?php } ?>
</div>
  
<div id="content-wrap">
   


  
