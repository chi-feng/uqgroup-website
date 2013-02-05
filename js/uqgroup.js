
$(document).ready(function() {
  
  if ($('#content').height() < $('#sidebar').height()) {
    $('#content').height($('#sidebar').height());
  }

});
  
$(function() {
	var sticky_navigation_offset_top = $('#nav-wrap').offset().top;
	var sticky_navigation = function(){
		var scroll_top = $(window).scrollTop();
		if (scroll_top > sticky_navigation_offset_top) { 
			$('#nav-wrap').css({ 'position': 'fixed', 'top':0 });
      $('#nav').addClass('stuck');   
      $('#sidebar-wrap, #content').css({'margin-top':'2.5em'});   
      $('#nav .totop').css({'opacity':'1'});   
		} else {
			$('#nav-wrap').css({ 'position': 'relative' }); 
      $('#nav').removeClass('stuck');
      $('#sidebar-wrap, #content').css({'margin-top':'0'});
      $('#nav .totop').css({'opacity':'0'});   
		}   
	};
	sticky_navigation();
	$(window).scroll(function() {
		 sticky_navigation();
	});	
});

function renderArticle(index, article) {

  var article_id = 'article-' + index;
  
  var authors = []; 
  $.each(article.authors, function(key, val) {
    authors.push('<span class="author">' + val + '</span>');
  });
  authors = '<div class="authors">\n' + authors.join(', ') + '</div>\n';
  
  var bibtex_raw = '@article { \n\
    author = "' + article.authors.join(' and ') + '", \n\
    title = "' + article.title + '", \n\
    journal = "' + article.journal + '", \n\
    volume = "' + article.volume + '", \n\
    number = "' + article.number + '", \n\
    pages = "' + article.pages + '", \n\
    doi = "' + article.doi + '", \n\
    keywords = "' + article.keywords + '"\n}';
  var bibtex = '<textarea class="bibtex">' + bibtex_raw + '</textarea>\n';
  var showbibtex = '<a class="button button-bottom"><i class="icon-book"></i> BibTeX</a>\n';
  var keywords = (article.keywords != undefined && article.keywords.length > 1) ? 
    '\n<div class="keywords"><strong>Keywords:</strong> ' + article.keywords + '</div>' : '';
  var abstract = '<div class="abstract hyphenate">\n' + article.abstract + keywords + '</div>\n';
  var showabstract = '<a class="button button-abstract"><i class="icon-eye-open"></i> Abstract</a>\n';
  var title = '<div class="title"><a href="' + article.fulltext + '">' + article.title + '</a></div>\n';
  var pages = (article.pages != undefined && article.pages.length > 1) ? ' pp. ' + article.pages : '';
  var journal = '<div class="journal">' + article.journal + ' <strong>' + article.volume + '</strong>' + pages + ' ('+ article.year + ')</div>\n';
  var linktext = (article.fulltext.toLowerCase().indexOf('arxiv') != -1) ? 'arXiv' : 'dx.doi';
  var link = '<a href="' + article.fulltext + '" class="button button-top" target="_new"><i class="icon-external-link"></i> ' + linktext + '</a>\n';  
  var zebra = (index % 2 == 0) ? 'even' : 'odd';   
  var thumbnail_url = (article.thumbnail != undefined && article.thumbnail.length > 1) ? 'images/publications/' + article.thumbnail : 'images/publications/none.png';
  var thumbnail_img = (thumbnail_url != '') ? '<img src="' + thumbnail_url + '" alt="thumbnail" />' : '';
  var thumbnail = '<a class="thumbnail" href="'+article.fulltext+'" target="_new">' + thumbnail_img + '</a>';
  var article = ['<div id="' + article_id +'" class="article ' + zebra + '">\n', thumbnail, link, showabstract, showbibtex, authors, title, journal, abstract, bibtex, '</div>\n'].join('');
  $('.articles').append(article);
}


function articlesAttachHover() {

  $('textarea.bibtex').click(function() { $(this).select(); });

  $(".articles .article").hover(
    function () {
      $(this).find($("a.button")).addClass('active');
      $(this).find($("a.thumbnail")).addClass('thumbnail-active');
    },
    function () {
      $(this).find($("a.button")).removeClass('active');
      $(this).find($("a.thumbnail")).removeClass('thumbnail-active');
    }
  );
    
  $('.button-abstract').click(function() {
    $(this).toggleClass('selected');
    $(this).parent().parent().find('.abstract').slideToggle();
  });
    
  $('.button-bottom').click(function() {
    $(this).toggleClass('selected');
    $(this).parent().parent().find('.bibtex').slideToggle();
  });
    
}

function articleFilter() {
  
  var count = 0;
  
  var year = $('#select-year').val();
  var author = $('#select-author').val();
  var journal = $('#select-journal').val();
  var keyword = $('#input-keyword').val().toLowerCase();
  
  $.each(articles, function(index, article) {
    var selector = '#article-' + index;
    
    var allowed = true;    
    
    if (keyword != '' && keyword != 'keyword') {
      if (article.keywords == undefined) {
        allowed = false;
      } else if (article.keywords.toLowerCase().indexOf(keyword) != -1) { 
        allowed = true; 
      } else if (article.title.toLowerCase().indexOf(keyword) != -1) { 
        allowed = true; 
      } else if (article.journal.toLowerCase().indexOf(keyword) != -1) { 
        allowed = true; 
      } else {
        allowed = false;
      }
    } 
    
    if (year != '' && article.year.indexOf(year) == -1) { 
      allowed = false; 
    }
    if (author != '' && $.inArray(author, article.authors) == -1) {
      allowed = false; 
    }
    if (journal != '' && article.journal.indexOf(journal) == -1) { 
      allowed = false; 
    }

    
    if (allowed) {
      if (count == 0) {
        $('.articles').show();
        $('#notfound').hide();
      }
      $(selector).show();
      count = count + 1;
    } else {
      $(selector).hide();
    }
    
  });
  
  if (count == 0) {
    $('.articles').hide();
    $('#notfound').show();
  }
  
}
