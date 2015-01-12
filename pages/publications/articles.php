<?php
$template = Template::getInstance();
$template->title = 'Journal Publications';
$template->tab = 'Publications';
?>
<div id="publication-switcher" class="clearfix">
  <h3 id="journal-publications" class="active"><a href="/publications/articles">Journal Articles</a></h3>
  <h3 id="conference-publications"><a href="/publications/conferences">Conference Publications</a></h3>
  <h3 id="book-chapters"><a href="/publications/books-other">Books &amp; Other Press</a></h3>
</div>

<form id="publications-form">
  <table>
    <tr>
      <td><select id="select-year"><option value="">Year</option><optgroup label='-'></optgroup></select></td>
      <td><select id="select-author"><option value="">Author</option><optgroup label='-'></optgroup></select></td>
      <td><select id="select-journal"><option value="">Journal</option><optgroup label='-'></optgroup></select></td>
      <td><input type="text" id="input-keyword" value="Keyword" /></td>
      <td><a class="btn" onclick="resetFilters()">Reset</a></td>
    </tr>
  </table>
</form>

<div id="articles-wrapper" class="clearfix">  
<div id="articles" class="articles">
<?php 
$articles = json_decode(file_get_contents('json/articles.json'), true);
foreach ($articles as $index => $article) {
  echo render_article($index, $article);
}
?>
<p id="notfound" style="display:none"><strong>No articles found matching filter.</strong></p>
</div>
</div>


<script type="text/javascript" src="/js/jquery.simplemodal.js"></script>
<script type="text/javascript">
//<![CDATA[

function populateFilters(articles) {
  
  var d = new Date();
  var options = [];    
  for (var year = d.getFullYear(); year >= 1998; year--) {
    options.push('<option class="year" value="' + year + '">' + year + '</option>');
  }
  $('#select-year').append(options);
  
  var hash = {};
  var authors = []; 
  $.each(articles, function(key, article) {
    $.each(article.authors, function(key, val) {
      if (!hash.hasOwnProperty(val)) {
        hash[val] = true;
        authors.push(val);
      }
    });    
  });
  authors.sort();
  options = [];
  $.each(authors, function(key, val) {
    options.push('<option class="author" value="' + val + '">' + val + '</option>');
  });
  $('#select-author').append(options);

  hash = {};
  var journals = []; 
  $.each(articles, function(key, article) {
    if (!hash.hasOwnProperty(article.journal)) {
      hash[article.journal] = true;
      journals.push(article.journal);
    }   
  });
  journals.sort();
  options = [];
  $.each(journals, function(key, val) {
    options.push('<option value="' + val + '">' + val + '</option>');
  });
  $('#select-journal').append(options);
}

function resetFilters() {
  $('select').val('');
  $('input').val('Keyword');
  articleFilter();
}

var articles = [];

$(document).ready(function() {
  
  $.getJSON('/json/articles.json', function(data) {
    articles = data;
    populateFilters(articles);
    articlesAttachHover();
    $("#publication-switcher-wrapper").height($('#articles').height() + 5);
  });
    
  $("#publications-form select").change(function () {
    articleFilter();
  });
    
  $("#input-keyword").keyup(function (e) {
    articleFilter();
  });
    
  $("#input-keyword").blur(function () {
    if ($(this).val() == '') $(this).val('Keyword')
  });
    
  $("#input-keyword").focus(function () {
    if ($(this).val() == 'Keyword') $(this).val('');
  });

  
  
});


//]]>
</script>
