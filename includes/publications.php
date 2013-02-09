<?php if (!defined('INCLUDE_GUARD')) { header("HTTP/1.0 403 Forbidden"); die(); } 

require_once('includes/json.php');

function show_articles($arr) {
  global $articles;
  $index = 0;
  foreach ($articles as $article) {
    if (in_array(intval($article['order']), $arr)) {
      echo render_article($index++, $article);
    }
  }
}

function get_article_authors() {
  global $articles;
  $hashmap = array();
  $authors = array();
  foreach ($articles as $index => $article) {
    foreach ($article['authors'] as $author) {
      if (!isset($hashmap[$author])) {
        $hashmap[$author] = true;
        $authors[] = $author;
      }
    }
  }
  sort($authors);
  return $authors;
}

function get_article_journals() {
  global $articles;
  $hashmap = array();
  $journals = array();
  foreach ($articles as $index => $article) {
    if (!isset($hashmap[$article['journal']])) {
      $hashmap[$article['journal']] = 0;
      $journals[] = $article['journal'];
    }
  }
  sort ($journals);
  return $journals;
}

function render_article($index, $article) {
  $article_id = "article-$index";
  
  $authors = array();
  foreach($article['authors'] as $author) {
    $authors[] = "<span class=\"author\">$author</span>\n";
  }
  $authors = "<div class=\"authors\">\n" . implode('', $authors) . "</div>\n";
  
  $title = '<div class="title"><a href="' . $article['fulltext'] . '">' . $article['title'] . '</a></div>'."\n";
  $pages = (isset($article['pages']) && !empty($article['pages'])) ? ' pp. ' . $article['pages'] : '';
  $journal = '<div class="journal">' . $article['journal'] . ' <strong>' . $article['volume'] . '</strong>' . $pages . ' (' . $article['year'] . ')</div>'. "\n";
  
  $bibtex_raw = array(
    '@article {', 
    'title = "' . $article['title'] . '"',
    'author = "' . implode(' and ', $article['authors']) . '"',
    'journal = "' . $article['journal'] . '"',
    'volume = "' . $article['volume'] . '"',
    'number = "' . $article['number'] . '"',
    'pages = "' . $article['pages'] . '"',
    'doi = "' . $article['doi'] . '"',
    'keywords = "' . $article['keywords'] . '"', "}\n");
  $bibtex_raw = implode("\n", $bibtex_raw);
  $bibtex = "<textarea class=\"bibtex\">$bibtex_raw</textarea>\n";
  
  $buttons = implode("\n", array(
    '<a href="' . $article['fulltext'] . '" class="button button-fulltext" target="_new"><span>Fulltext</span><i class="icon-external-link"></i></a>',
    '<a class="button button-bibtex"><span>BibTeX</span><i class="icon-book"></i> </a>',
    '<a class="button button-abstract"><span>Abstract</span><i class="icon-eye-open"></i></a>'
  ));
  $buttons = "<div class=\"article-buttons\">\n$buttons\n</div>\n";
  
  $keywords = (isset($article['keywords']) ? '<div class="keywords"><strong>Keywords: </strong>' . $artice['keywords'] .'</div>' : '');
  $thumbnail_src = (isset($article['thumbnail']) && !empty($article['thumbnail'])) ? 'images/publications/' . $article['thumbnail'] : 'images/publications/none.png';
  $thumbnail = '<a href="' . $article['fulltext'] . '"><img class="thumbnail" src="'. $thumbnail_src .'" /></a>' . "\n";

  $abstract = '<div class="abstract">'.$article['abstract']."</div>\n";
  
  $fulltext = "<div class=\"fulltext\"><h4>Fulltext Options</h4>\n";
  $fulltext .= '<a class="btn external" href="'.$article['fulltext'].'">View on External Site <i class="icon-external-link"></i> </a>';
  $fulltext .= '<code class="block">'.htmlspecialchars($article['fulltext']).'</code><br />';
  if (isset($article['arxiv']) && !empty($article['arxiv'])) {
    $link = $article['arxiv'];
    if (strpos($article['arxiv'], 'http') === false) {
      $link = 'http://arxiv.org/abs/' . $article['arxiv'];
    }
    $fulltext .= '<a class="btn" href="'.$link.'">View on arXiv.org <img class="float-right" src="images/open-access.png" height="20" alt="open-access" /></a>';
  }
  $fulltext .= '</div>'."\n";
  
  $zebra = ($index % 2 == 0) ? 'even' : 'odd';
  
  $div = implode('', array('<div id="'.$article_id.'" class="article '.$zebra.'">',
    $thumbnail, $buttons, $authors, $title, $journal, $fulltext, $abstract, $bibtex,
    "</div>\n"));
  
  return $div;
}

?>