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
      $daterange = '';
      if (!empty($event['end_date']) && $event['end_date'] != $event['start_date']) {
        $daterange = $event['start_date'].' - '.$event['end_date'];
      } elseif (!empty($event['start_time'])) {
        $daterange = $event['start_date'] . ' ' . $event['start_time'];
        if (!empty($event['end_time'])) {
          $daterange .= ' - '.$event['end_time'];
        }
      } else {
        $daterage = $event['start_date'];
      }
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

function truncate($str, $len) {
  if (strlen($str) > $len) {
    return substr($str, 0, $len - 3) . '...';
  } else {
    return $str;
  }
}

function prettyPrint( $json )
{
    $result = '';
    $level = 0;
    $prev_char = '';
    $in_quotes = false;
    $ends_line_level = NULL;
    $json_length = strlen( $json );

    for( $i = 0; $i < $json_length; $i++ ) {
        $char = $json[$i];
        $new_line_level = NULL;
        $post = "";
        if( $ends_line_level !== NULL ) {
            $new_line_level = $ends_line_level;
            $ends_line_level = NULL;
        }
        if( $char === '"' && $prev_char != '\\' ) {
            $in_quotes = !$in_quotes;
        } else if( ! $in_quotes ) {
            switch( $char ) {
                case '}': case ']':
                    $level--;
                    $ends_line_level = NULL;
                    $new_line_level = $level;
                    break;

                case '{': case '[':
                    $level++;
                case ',':
                    $ends_line_level = $level;
                    break;

                case ':':
                    $post = " ";
                    break;

                case " ": case "\t": case "\n": case "\r":
                    $char = "";
                    $ends_line_level = $new_line_level;
                    $new_line_level = NULL;
                    break;
            }
        }
        if( $new_line_level !== NULL ) {
            $result .= "\n".str_repeat( "\t", $new_line_level );
        }
        $result .= $char.$post;
        $prev_char = $char;
    }

    return $result;
}

?>