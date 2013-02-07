<?php if (!defined('INCLUDE_GUARD')) { header("HTTP/1.0 403 Forbidden"); die(); } 

function get_upcoming_events($limit = 0) {
  global $events;
  $return = '';
  $event_count = 0;
  foreach ($events as $index => $event) {
    if ($limit == -1 || strtotime($event['start_date'] . ' ' . $event['start_time']) > time()) {
      if ($limit > 0 && $event_count < $limit) {
        $event_count++;
      } else if ($limit == -1) {
        
      } else {
        break;
      }
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
      $return .= sprintf("          <p><strong>%s</strong><br />%s %s</p>\n",
        $daterange, $event['name'], $link);
    }
  }
  return $return;
}

function render_conference($idx, $conference) {
  $return = array();
  $return[] = '<div class="conference">';
  $return[] = '<span class="conference-order">'. $conference['order'] .'.</span>';
  $return[] = '<span class="conference-authors">'. implode(', ', $conference['authors']) .',</span>';
  $return[] = '<span class="conference-title">&ldquo;'. $conference['title'] .'.&rdquo;</span>';
  $return[] = '<span class="conference-conference">'. $conference['conference'] .'</span>';
  if (strlen($conference['publication'])) {
    $return[] = '<span class="conference-publication">'. $conference['publication'] .'</span>';
  }
  $return[] = '<span class="conference-year">('. $conference['year'] .')</span>';
  if (strlen($conference['url'])) {
    $return[] = '<span class="conference-url">[<a href="'. $conference['url'] .'">Link</a>]</span>';
  }
  $return[] = '</div>';
  return implode("\n", $return);
}

?>