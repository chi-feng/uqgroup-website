
$(document).ready(function() {
  
$('a.sidebar-collapse-btn').click(function(event) {
  var content = $(this).parent().find('.sidebar-content');
  if (content.is(":visible")) {
    content.stop(true, true);
    content.animate({height:"toggle",opacity:"toggle"}, 200);
    $(this).find('i').removeClass('icon-minus').addClass('icon-plus');
  } else {
    content.stop(true, true);
    content.animate({height:"toggle",opacity:"toggle"}, 200);
    $(this).find('i').removeClass('icon-plus').addClass('icon-minus');
  }
});

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
  var title = '<div class="title">' + article.title + '</div>\n';
  var pages = (article.pages != undefined && article.pages.length > 1) ? ' pp. ' + article.pages : '';
  var journal = '<div class="journal">' + article.journal + ' <strong>' + article.volume + '</strong>' + pages + ' ('+ article.year + ')</div>\n';
  var link = '<a href="' + article.fulltext + '" class="button button-top" target="_new"><i class="icon-external-link"></i> Fulltext</a>\n';  
  var zebra = (index % 2 == 0) ? 'even' : 'odd';   
  var article = ['<div class="article ' + zebra + '">\n', link, showabstract, showbibtex, authors, title, journal, abstract, bibtex, '</div>\n'].join('');
  $('#articles').append(article);
}

function articlesAttachHover() {

  $('textarea.bibtex').click(function() { $(this).select(); });

  $("#articles .article").hover(
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
    $(this).parent().find('.abstract').slideToggle();
  });
    
  $('.button-bottom').click(function() {
    $(this).toggleClass('selected');
    $(this).parent().find('.bibtex').slideToggle();
  });
    
}
