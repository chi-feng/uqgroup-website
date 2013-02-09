<?php if (!defined('INCLUDE_GUARD')) { header("HTTP/1.0 403 Forbidden"); die(); } ?>

<div id="publication-switcher" class="clearfix">
  <h3 id="journal-publications" class="active">Journal Articles</h3>
  <h3 id="conference-publications">Conference Publications</h3>
  <h3 id="book-chapters">Books &amp; Other Press</h3>
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

<div id="publication-switcher-wrapper">
<div id="articles-wrapper" class="clearfix">  
<div id="articles" class="articles">
<?php
  
foreach ($articles as $index => $article) {
  echo render_article($index, $article);
}
    
?>
  <p id="notfound" style="display:none"><strong>No articles found matching filter.</strong></p>
</div>
</div>
<div id="conferences-wrapper">
<div id="conferences">
<h4 id="refereed">Refereed Conference Publications</h4>
<?php
  
foreach ($conferences as $index => $conference) {
  echo render_conference($index, $conference);
}
    
?>
</div>
</div>
<div id="books-wrapper">
<div id="books">

<h4 id="books-and-chapters">Books and Book Chapters</h4>
<ol>
  <li>Frangos, M., Marzouk, Y.M., Willcox, K.E., van Bloemen Waanders, B. “Surrogate and reduced-order models for statistical inverse problems.” Chapter in Biegler, Biros, Ghattas, Heinkenschloss, Keyes, Mallick, Marzouk, Tenorio, van Bloemen Waanders, &amp; Willcox (eds.), Computational Methods for Large Scale Inverse Problems and Uncertainty Quantification, Wiley (2010).</li>
  <li>L. Biegler, G. Biros, O. Ghattas, M. Heinkenschloss, D. Keyes, B. Mallick, Y. Marzouk, L. Tenorio, B. van Bloemen Waanders, and K. Willcox, editors. <em>Computational Methods for Large Scale Inverse Problems and Uncertainty Quantification</em><em>. </em>Wiley (2010). </li>
</ol>

<h4 id="other-publications">Magazine Articles and Other Press</h4>
<ol>
  <li>Marzouk, Y.M., Willcox, K.E.,  &quot;Confronting energy and environment's toughest challenges with computational engineering.&quot; AeroAstro Magazine No. 7, 2009–2010. [<a href="http://web.mit.edu/aeroastro/news/magazine/aeroastro7/compu-engineering.html">link</a>]</li>
</ol>

</div>
</div>
</div>
<div id="other">
</div>

<script type="text/javascript" src="js/jquery.simplemodal.js"></script>
<script type="text/javascript">
//<![CDATA[

function copyToClipboard (selector) {
  window.prompt ("Copy to clipboard: Ctrl+C, Enter", $(selector).html());
}

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

function switchPane(header, left1, left2, left3, maxheight) {
  $('#publication-switcher h3').removeClass('active');
  $(header).addClass('active');
  $('#articles-wrapper').stop().animate({'left':left1}, 300);
  $('#conferences-wrapper').stop().animate({'left':left2}, 300);
  $('#books-wrapper').stop().animate({'left':left3}, 300);
  $("#publication-switcher-wrapper").height(maxheight);
  if (left1 == '0em') {
    $('#select-journal').removeAttr('disabled').removeClass('disabled');
  } else {
    $('#select-journal').attr('disabled', 'disabled').addClass('disabled');
  }
}

var articles = [];

$(document).ready(function() {
  
  $.getJSON('json/articles.json', function(data) {
    articles = data;
    populateFilters(articles);
    articlesAttachHover();
    $("#publication-switcher-wrapper").height($('#articles').height() + 30);
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
  
  $("#journal-publications").click(function() {
    switchPane($(this), '0em', '50em', '100em', $('#articles').height());
  });
  
  $("#conference-publications").click(function() {
    switchPane($(this), '-50em', '0em', '50em', $('#conferences').height() + 30);
  });
  
  $("#book-chapters").click(function() {
    switchPane($(this), '-100em', '-50em', '0em', $('#books').height());
  });
  
  
});


//]]>
</script>


