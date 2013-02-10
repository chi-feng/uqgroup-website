<?php if (!defined('INCLUDE_GUARD')) { header("HTTP/1.0 403 Forbidden"); die(); } 

require_once('includes/json.php');

function truncate($str, $len) {
  if (strlen($str) > $len) {
    return substr($str, 0, $len - 3) . '...';
  } else {
    return $str;
  }
}

class Object {
  
  protected $name; 
  protected $fields;
  protected $data;
  protected $json_path;
  protected $sort_by;

  public function __construct($arg1, $arg2 = '') {
    if ($arg1 === 'post') {
      $this->from_array($_POST);
    } else if (is_array($arg1)) {
      $this->from_array($arg1);
    } else {
      $this->from_existing($arg1, $arg2);
    }
  }

  public function get($field) {
    return $this->data[$field];
  }
  
  public function set($field, $value) {
    $this->data[$field] = $value;
  }
  
  public function from_existing($field, $value) {
    $arr = json_decode(file_get_contents($this->json_path), true);
    $found = false;
    foreach ($arr as $key => $item) {
      if ($item[$field] == $value) {
        $this->data = $arr[$key];
        $found = true;
      }
    }
    return $found;
  }
  
  public function from_array($arr) {
    foreach ($this->fields as $name => $field) {
      if ($field['type'] != 'array') {
        $this->data[$name] = $arr[$name];
      } else {
        $this->data[$name] = array();
        $elements = explode("\n", $arr[$name]);
        foreach ($elements as $element) {
          $this->data[$name][] = trim($element);
        }
      }
    }
  }
  
  public function max_id($arr) {
    $max_index = 0;
    foreach ($arr as $key => $item) {
      if (intval($item['id']) > $max_index) {
        $max_index = intval($item['id']);
      }
    }
    return $max_index;
  }
  
  public function insert_front() {
    $arr = json_decode(file_get_contents($this->json_path), true);
    $this->data['id'] = strval($this->max_id($arr) + 1);
    array_unshift($arr, $this->data);
    $json = prettyPrint(json_encode($arr));
    file_put_contents($this->json_path, $json);
  }
  
  public function insert_back() {
    $arr = json_decode(file_get_contents($this->json_path), true);
    $this->data['id'] = strval($this->max_id($arr) + 1);
    $arr[] = $this->data;
    $json = prettyPrint(json_encode($arr));
    file_put_contents($this->json_path, $json);
  }
  
  public function update($field, $value) {
    $arr = json_decode(file_get_contents($this->json_path), true);
    $found = false;
    foreach ($arr as $key => $item) {
      if ($item[$field] == $value) {
        $arr[$key] = $this->data; 
        $found = true;
      }
    }
    if ($found) {
      $json = prettyPrint(json_encode($arr));
      file_put_contents($this->json_path, $json);
      return true;
    } else {
      return false;
    }
  }
  
  public function delete($field, $value) {
    $arr = json_decode(file_get_contents($this->json_path), true);
    $found = false;
    foreach ($arr as $key => $item) {
      if ($item[$field] == $value) {
        unset($arr[$key]);
        $found = true;
      }
    }
    if ($found) {
      $json = prettyPrint(json_encode($arr));
      file_put_contents($this->json_path, $json);
      return true;
    } else {
      return false;
    }
  }
  
  public function sort_function_asc($a, $b) {
    if (strpos($this->sort_by, 'date')) {
      return strtotime($a[$this->sort_by]) > strtotime($b[$this->sort_by]);
    }
    return $a[$this->sort_by] > $b[$this->sort_by];
  }
  
  public function sort_function_desc($a, $b) {
    if (strpos($this->sort_by, 'date')) {
      return strtotime($a[$this->sort_by]) < strtotime($b[$this->sort_by]);
    }
    return $a[$this->sort_by] < $b[$this->sort_by];
  }
  
  public function sort($direction) {
    $arr = json_decode(file_get_contents($this->json_path), true);
    if (substr(strtolower($direction), 0, 4) == 'desc') {
      usort($arr, array($this, 'sort_function_desc'));
    } else {
      usort($arr, array($this, 'sort_function_asc'));
    }
    $json = prettyPrint(json_encode($arr));
    file_put_contents($this->json_path, $json);
  }
  
  private function formfields() {
    $return = '';
    foreach ($this->fields as $name => $field) {
      if ($field['type'] != 'hidden') {
        $return .= '<label class="label-'.$name.'">'.$field['label'].'</label>';
      }
      switch ($field['type']) {
        case 'text':
        $return .= '<input type="text" name="'.$name.'" class="input-'.$name.'" value="'.$this->data[$name].'" />';
        break;
        case 'textarea':
        $return .= '<textarea class="textarea-'.$name.'" name="'.$name.'" />'.$this->data[$name].'</textarea>';
        break;
        case 'hidden':
        $return .= '<input type="hidden" name="'.$name.'" value="'.$this->data[$name].'" />';
        break;
        case 'month':
        $return .= '<select name="'.$name.'" class="select-'.$name.'">';
        $months = array('','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
        foreach ($months as $idx => $month) {
          if ($idx == $this->data[$name] || $month == $this->data[$name]) {
            $return .= '<option value="'.$idx.'" selected="selected">'.$month.'</option>';
          } else { 
            $return .= '<option value="'.$idx.'">'.$month.'</option>';
          }
        }
        $return .= '</select>';
        break;
        case 'date':
        $return .= '<input type="text" name="'.$name.'" class="input-date input-'.$name.'" value="'.$this->data[$name].'" />';
        break;
        case 'time':
        $return .= '<input type="text" name="'.$name.'" class="input-time input-'.$name.'" value="'.$this->data[$name].'" />';
        break;
        case 'array':
        $value = implode("\n", $this->data[$name]);
        $return .= '<textarea class="textarea-'.$name.'" name="'.$name.'" />'.$value.'</textarea>';
        break;
      }
    }
    return $return;
  }
  
  public function edit() {
    $return = '<h2>Editing '.$this->name.'</h2>';
    $return .= '<form class="edit-'.$this->name.'" action="admin.php?" method="post">';
    $return .= '<fieldset><legend>Edit '.$this->name.'</legend>';
    $return .= $this->formfields();
    $return .= '<input type="hidden" name="id" value="'.$this->data['id'].'" />';
    $return .= '<input type="hidden" name="update_'.$this->name.'" value="true" />';
    $return .= '<label></label><input type="submit" value="Update" class="btn" />';
    $return .= '</fieldset></form>';
    return $return;
  }
  
  public function create() {
    $return = '<h2>Create '.$this->name.'</h2>';
    $return .= '<form class="create-'.$this->name.'" action="admin.php?" method="post">';
    $return .= '<fieldset><legend>Create '.$this->name.'</legend>';
    $return .= $this->formfields();
    $return .= '<input type="hidden" name="insert_'.$this->name.'" value="true" />';
    $return .= '<label></label><input type="submit" value="Create" class="btn" />';
    $return .= '</fieldset></form>';
    return $return;
  }
  
  private function recurse($arr, $depth=0) {
    $return = '';
    if ($depth > 0) {
      $return = '<table class="recurse">';
    }
    foreach ($arr as $key => $val) {
      if ($depth == 0) {
        $return .= '<table class="recurse">';
      }
      $value = '';
      if (is_array($val)) {
        $value = $this->recurse($val, $depth + 1);
      } else {
        $maxlen = 50 - ($depth * 10); 
        if (strlen($val) > $maxlen) {
          $value = substr($val, 0, $maxlen - 3) . '...'; 
        } else {
          $value = $val;
        }
      }
      $return .= sprintf('<tr><td class="field">%s</td><td class="value">%s</td></tr>', 
        htmlspecialchars($key), $value);
      if ($depth == 0) {
        $return .= '</table>';
      }
    }
    if ($depth > 0) {
      $return .= '</table>';
    }
    return $return;
  }
  
  public function dump() {
    $arr = json_decode(file_get_contents($this->json_path), true);
    return $this->recurse($arr);
  }
  
  public function viewrow($row) {
    $return = '';
    foreach($this->list_field as $field_name) {
      $value = truncate($row[$field_name], 100);
      $return .= '<td class="value">' . $value .'</td>';
    }
    return $return;
  }
  
  public function viewall() {
    $return = '<h2>Viewing all '.$this->name.'s <a class="btn quick-add" href="admin.php?create_'.$this->name.'">Create New</a></h2>';
    $return .= '<table class="list list-'. $this->name.'">';
    $arr = json_decode(file_get_contents($this->json_path), true);
    $return .= '<thead><tr><th></th>';
    foreach($this->list_field as $field_name) {
      $return .= '<th>'.$field_name.'</th>';
    }
    $return .= '<th></th></tr></thead><tbody>';
    foreach ($arr as $idx => $val) {
      $return .= '<tr class="list-'.$this->name.'">';
      $return .= '<td class="edit-button">';
      $return .= '<a class="edit-button" href="admin.php?edit_'.$this->name.'&id='.$val['id'].'"><i class="icon-pencil"></i></a>';
      $return .= '</td>';
      $return .= $this->viewrow($val);
      $return .= '<td class="delete-button">';
      $return .= '<a class="delete-button confirm" href="admin.php?delete_'.$this->name.'&id='.$val['id'].'"><i class="icon-trash"></i></a>';
      $return .= '</td>';
      $return .= '</tr>';
    }
    $return .= '</tbody></table>';
    return $return;
  }
  
  public function view() {
    return $this->recurse($this->data, 1);
  }
  
}

class Announcement extends Object {
  public function __construct($arg1, $arg2 = '') {
    $this->name = 'announcement';
    $this->json_path = 'json/announcements.json';
    $this->fields = array(
      'id' => array('label' => 'ID', 'type' => 'hidden'), 
      'date' => array('label' => 'Date', 'type' => 'date'), 
      'content' => array('label' => 'Content', 'type' => 'textarea')
    );
    $this->sort_by = 'id';
    $this->list_field = array('content', 'date');
    parent::__construct($arg1, $arg2);
  }  
}

class Event extends Object {
  public function __construct($arg1, $arg2 = '') {
    $this->name = 'event';
    $this->json_path = 'json/events.json';
    $this->fields = array(
      'id' => array('label' => 'ID', 'type' => 'hidden'), 
      'start_date' => array('label' => 'Start Date', 'type' => 'date'), 
      'end_date' => array('label' => 'End Date', 'type' => 'date'), 
      'start_time' => array('label' => 'Start Time', 'type' => 'time'), 
      'end_time' => array('label' => 'End Time', 'type' => 'time'), 
      'name' => array('label' => 'Name', 'type' => 'text'), 
      'location' => array('label' => 'Location', 'type' => 'text'), 
      'content' => array('label' => 'Content', 'type' => 'textarea')
    );
    $this->sort_by = 'start_date';
    $this->list_field = array('name', 'start_date');
    parent::__construct($arg1, $arg2);
  }  
}

class Article extends Object {
  public function __construct($arg1, $arg2 = '') {
    $this->name = 'article';
    $this->json_path = 'json/articles.json';
    $this->fields = array(
      'id' => array('label' => 'ID', 'type' => 'hidden'),  
      'title' => array('label' => 'Title', 'type' => 'text'),  
      'keywords' => array('label' => 'Keywords', 'type' => 'text'),  
      'authors' => array('label' => 'Authors', 'type' => 'array'), 
      'abstract' => array('label' => 'Abstract', 'type' => 'textarea'),  
      'order' => array('label' => 'Order ID', 'type' => 'text'),   
      'fulltext' => array('label' => 'Fulltext URL', 'type' => 'text'),  
      'journal' => array('label' => 'Journal', 'type' => 'text'),  
      'doi' => array('label' => 'DOI', 'type' => 'text'),  
      'year' => array('label' => 'Year', 'type' => 'text'),  
      'arxiv' => array('label' => 'arXiv', 'type' => 'text'),  
      'volume' => array('label' => 'Volume', 'type' => 'text'),  
      'thumbnail' => array('label' => 'Thumbnail', 'type' => 'text'),
      'number' => array('label' => 'Number', 'type' => 'text'),  
      'month' => array('label' => 'Month', 'type' => 'month'),  
      'pages' => array('label' => 'Pages', 'type' => 'text'),  
      'comments' => array('label' => 'Comments', 'type' => 'text')
    );
    $this->sort_by = 'order';
    $this->list_field = array('OID', 'Article');
    parent::__construct($arg1, $arg2);
  }
  
  public function get_max_order() {
    $arr = json_decode(file_get_contents($this->json_path), true);
    $max_index = 0;
    foreach ($arr as $key => $item) {
      if (intval($item['order']) > $max_index) {
        $max_index = intval($item['order']);
      }
    }
    return $max_index;
  }
  
  public function viewrow($row) {
    $authors = truncate(implode(', ', $row['authors']), 80);
    $title = truncate($row['title'], 80);
    $journal = sprintf('%s <strong>%s:</strong> (%s)', 
      $row['journal'], $row['volume'], $row['year']);
    $return .= sprintf('<td class="value center">%s</td><td class="value">%s &ldquo;%s.&rdquo; %s</td>', 
      $row['order'], $authors, $title, $journal);
    return $return;
  }
  
}


class Conference extends Object {
  public function __construct($arg1, $arg2 = '') {
    $this->name = 'conference';
    $this->json_path = 'json/conferences.json';
    $this->fields = array(
      'id' => array('label' => 'ID', 'type' => 'hidden'),  
      'title' => array('label' => 'Title', 'type' => 'text'),  
      'authors' => array('label' => 'Authors', 'type' => 'array'),  
      'order' => array('label' => 'Order', 'type' => 'text'),  
      'conference' => array('label' => 'Conference', 'type' => 'text'),  
      'year' => array('label' => 'Year', 'type' => 'text'),  
      'publication' => array('label' => 'Publication', 'type' => 'text'),  
      'url' => array('label' => 'URL', 'type' => 'text'),
    );
    $this->sort_by = 'order';
    $this->list_field = array('order', 'title');
    parent::__construct($arg1, $arg2);
  }  
  public function get_max_order() {
    $arr = json_decode(file_get_contents($this->json_path), true);
    $max_index = 0;
    foreach ($arr as $key => $item) {
      if (intval($item['order']) > $max_index) {
        $max_index = intval($item['order']);
      }
    }
    return $max_index;
  }
}

?>