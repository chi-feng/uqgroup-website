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
  <script type="text/javascript" src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
  <?php
  if ($t['mathjax']) {
    echo '<script type="text/javascript" src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>';
  }
  ?>
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
  printf("      <li><a href=\"%s\"%s>%s</a></li>\n", $key, $active, $value['name']);
}
?>
      <a class="totop" onclick="$('html, body').animate({scrollTop:0}, 500);"><i class="icon-circle-arrow-up"></i></a>
    </ul>
  </div>
</div>
<div id="content-wrap" class="clearfix">
<div id="content" class="column">