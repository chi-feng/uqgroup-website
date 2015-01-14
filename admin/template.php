<?php  
global $t;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href="/css/font-awesome.css"  rel="stylesheet" type="text/css" />
  <link href='//fonts.googleapis.com/css?family=Titillium+Web:300' rel='stylesheet' type='text/css'>
  <link href='//fonts.googleapis.com/css?family=Arimo:400,700' rel='stylesheet' type='text/css'>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script type="text/javascript" src="/js/admin.js"></script>
  <link rel="stylesheet" type="text/css" href="/css/admin.css" media="screen" />
  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  <link rel="shortcut icon" href="favicon.ico" />  
</head>
<body>
  
<div class="menubar">

  <div id="nav"> 
  <ul>
  <li><a href="/admin/index.php"><i class="icon-cog"></i></a>
    <ul>
    <li><a href="/admin/index.php">Dashboard</a></li>
    <li><a href="http://uqgroup.mit.edu/home">Home</a></li>
    </ul>
  </li>
  <li><a href="/admin/index.php?view_announcements">Announcements</a>
    <ul>
    <li><a href="/admin/index.php?view_announcements">View Announcements</a></li>
    <li><a href="/admin/index.php?create_announcement">Create Announcement</a></li>
    </ul>
  </li>
  <li><a href="/admin/index.php?view_people">People</a>
    <ul>
    <li><a href="/admin/index.php?view_people">View People</a></li>
    <li><a href="/admin/index.php?create_person">Create Person</a></li>
    <li><a href="/admin/index.php?sort_people">Sort People</a></li>
    </ul>
  </li>
  <li><a href="/admin/index.php?view_articles">Articles</a>
    <ul>
    <li><a href="/admin/index.php?view_articles">View Articles</a></li>
    <li><a href="/admin/index.php?create_article">Create Article</a></li>
    <li><a class="confirm" href="/admin/index.php?sort_articles">Sort Articles by Order ID</a></li>
    </ul>
  </li>
  <li><a href="/admin/index.php?view_conferences">Conferences</a>
    <ul>
    <li><a href="/admin/index.php?view_conferences">View Conferences</a></li>
    <li><a href="/admin/index.php?create_conference">Create Conference</a></li>
    <li><a class="confirm" href="/admin/index.php?sort_conferences">Sort Conferences by Order ID</a></li>
    </ul>
  </li>
  </ul>
  </div>
</div>
  
<div id="content-wrap">

<?php echo $t['content']; ?>
  
</div>

<script type="text/javascript">

$(document).ready(function() {
  $('table tr:even').addClass('even');
  $('table tr:odd').addClass('odd');
  $('.input-date').datepicker({ dateFormat: "M d, yy" });
  $('.confirm').click(function(){return confirm("Are you sure?");});
  var article_auto_populate = '<div id="auto-populate" class="clearfix">\
  <p>Auto-populate from entry: Author, A.B., Author, C.D. "Title." Journal Name: Volume Pages (Year)</p>\
  <textarea class="auto-populate"></textarea><br />\
  </div>';
  $('form.create-article fieldset').prepend(article_auto_populate);
  $('textarea.auto-populate').keyup(function() {
    parse_article($('textarea.auto-populate').val());
  });
});

</script>
</body>
</html>
