<?php
$template = Template::getInstance();
$template->title = 'People';
$template->tab = 'People';

$people = json_decode(file_get_contents('json/people.json'), true);

function count_people($type) {
  global $people;
  $count = 0;

  foreach($people as $person) {
    if ($person['type'] == $type) 
      $count++;
  }
  return $count;
}

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
        echo '<li class="person"><img src="/images/people/'.$person['url'].'.png" alt="'.$person['name'].'" title="'.$person['name'].'" />
          <span class="name">'.$person['name'].'</span>
          <div class="bio" id="'.$person['url'].'"><p>'.$person['bio'].'</p></div>
          </li>';
    }
  }
  echo '</ul>';
}

function list_alumni($type) {
  global $people;
  echo '<ul class="list">';
  foreach($people as $person) {
    if ($person['type'] == $type) {
      echo '<li><strong>' . $person['name'] .'</strong> (' . $person['bio'] . ')</li>';
    }
  }
  echo '</ul>';
}

?>

<h2>Group Members</h2>

<div class="people-browser clearfix">  

  <h3>Principal Investigator</h3>
  <?php people_filter('pi'); ?>

  <h3>Postdoctoral Associates</h3>
  <?php people_filter('postdoc'); ?>
  
  <?php if (count_people('visitor') > 0) { ?>
  <h3>Current Visitors</h3>
  <?php people_filter('visitor'); ?>
  <?php } ?>

  <h3>Graduate Students, PhD</h3>
  <?php people_filter('phd'); ?>
  
  <h3>Graduate Students, SM</h3>
  <?php people_filter('sm'); ?>

  <?php if (count_people('urop') > 0) { ?>
  <h3>Undergraduate Students (UROP)</h3>
  <?php people_filter('urop'); ?>
  <?php } ?>

</div>

<br style="clear:both" />

<h2>Alumni</h2>
<div class="alumni">
  <div class="col-1-2">
  <h3>Postdoctoral Alumni</h3>
    <?php list_alumni('postdoc-alumn'); ?>
  <h3>Long Term Visitors</h3>
    <?php list_alumni('visitor-alumn'); ?>
  </div>
  <div class="col-2-2">
  <h3>Graduate Alumni</h3>
    <?php list_alumni('grad-alumn'); ?>
  <h3>Undergraduate Alumni</h3>
    <?php list_alumni('undergrad-alumn'); ?>
  </div>

</div>
<script type="text/javascript" src="/js/jquery.simplemodal.js"></script>
<script type="text/javascript">
</script>
