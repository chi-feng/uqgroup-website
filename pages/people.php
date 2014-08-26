<?php if (!defined('INCLUDE_GUARD')) { header("HTTP/1.0 403 Forbidden"); die(); } 

$t['nosidebar'] = true;

function people_filter($type) {
  echo '<ul class="'.$type.' clearfix">';
  global $people;
  if ($type == 'visitor') {
    foreach($people as $person) {
      if ($person['type'] == $type) 
        echo '<li class="person"><img src="/images/people/'.$person['url'].'.png" alt="'.$person['name'].'" title="'.$person['name'].'" />
          <span class="name">'.$person['name'].'</span>
          <span class="info small">'.$person['institution'].'</span>
          </li>';
    }
  } elseif ($type == 'urop') {
    foreach($people as $person) {
      if ($person['type'] == $type) 
        echo '<li class="person"><img src="/images/people/'.$person['url'].'.png" alt="'.$person['name'].'" title="'.$person['name'].'" />
          <span class="name">'.$person['name'].'</span>
          <span class="info"><a href="/people/'.$person['url'].'">bio</a></span>
          </li>';
    }
  } else {
    foreach($people as $person) {
      if ($person['type'] == $type) 
        echo '<li class="person"><a class="bio-button" rel="'.$person['url'].'"><img src="/images/people/'.$person['url'].'.png" alt="'.$person['name'].'" title="'.$person['name'].'" />
          <span class="name">'.$person['name'].'</span></a>
          <span class="info"><a href="mailto:'.$person['email'].' at mit dot edu">email</a>&nbsp;|&nbsp;<a class="bio-button" rel="'.$person['url'].'">bio</a></span>
          </li>';
        echo '<div class="bio" id="'.$person['url'].'"><h3>'.$person['name'].'</h3><p>'.$person['bio'].'</p></div>';
    }
  }
  echo '</ul>';
}
?>

<h2>Group Members</h2>

<div class="people-browser clearfix">  
  <div class="col-1-2">

  <div style="width:37%;float:left;margin-right:13%">
    <h3>Principal Investigator</h3>
    <?php people_filter('pi'); ?>
  </div>

  <!--
  <div style="width:50%;float:left;">
    <h3>Current Visitors</h3>
    <?php people_filter('visitor'); ?>
  </div>
  -->

  <h3>Graduate Students, PhD</h3>
  <?php people_filter('phd'); ?>
  
  <h3>Undergraduate Students (UROP)</h3>
  <ul style="background: none">
    <li><a>Yair Shenfeld</a></li>
  </ul>

    
  </div>
  <div class="col-2-2">
  
    <h3>Postdoctoral Associates</h3>
    <?php people_filter('postdoc'); ?>
    
    <h3>Graduate Students, SM</h3>
    <?php people_filter('sm'); ?>
  </div>
</div>
<br style="clear:both" />

<h2>Alumni</h2>
<div class="alumni">
  <div class="col-1-2">
  <h3>Postdoctoral Alumni</h3>
  <ul class="list">
    <li><strong>Ingrid Berkelmans</strong> (Cambridge Chemical Technologies)</li>
    <li><strong>Sonjoy Das</strong> (Univ. of Buffalo, Mechanical Engineering) <a href="http://lotus.eng.buffalo.edu/">www</a></li>
    <li><strong>Michalis Frangos</strong> (Schlumberger)</li>
    <li><strong>Jinglai Li</strong> (Shanghai Jiaotong University) <a href="http://www.jinglaili.net/">www</a></li>
    <li><strong>Tarek El Moselhy</strong> (D. E. Shaw Group) <a href="http://web.mit.edu/tmoselhy/www/">www</a></li>
    <li><strong>Ankur Srivastava</strong> (GE Global Research) </li>
  </ul>
  <h3>Long Term Visitors</h3>
  <ul class="list">
    <li><strong>Daniele Bigoni</strong> (Tech. Univ. of Denmark)</li>
    <li><strong>Ben Calderhead</strong> (Imperial College London)</li>
    <li><strong>Dominic Kohler</strong> (Siemens AG)</li>
    <li><strong>Jinglai Li</strong> (Shanghai Jiaotong University)</li>
    <li><strong>Lionel Mathelin</strong> (LIMSI/CNRS France)</strong></li>
    <li><strong>Faidra Stavropoulou</strong> (TU Munich)</li>
  </ul>
  </div>
  <div class="col-2-2">
  <h3>Graduate Alumni</h3>
  <ul class="list">
    <li><strong>Thomas Coles</strong> (MIT)</li>
    <li><strong>Subhadeep Mitra</strong> (Citibank)</li>
    <li><strong>Naveen Krishnakumar</strong> (Grantham Mayo van Otterloo)</li>
  </ul>
  <h3>Undergraduate Alumni</h3>
  <ul class="list">
    <li><strong>Tomas Kogan</strong> (Cambridge University)</li>
    <li><strong>Kevin Lim</strong> (Princeton University, Economics)</li>
    <li><strong>Hadi Kasab</strong> (American University of Beirut)</li>
    <li><strong>George Hansel</strong> (MIT)</li>
    <li><strong>Michael Lieu</strong> (MIT)</li>
    <li><strong>Savithru Jayasinghe</strong> (Cambridge University)</li>
  </ul>
  </div>

</div>
<script type="text/javascript" src="/js/jquery.simplemodal.js"></script>
<script type="text/javascript">
$( document ).ready(function() {
  $('.bio-button').click(function (e) {
    var id = $(this).attr('rel');
    $('#'+id).modal();
    return false;
  });
});
  </script>
