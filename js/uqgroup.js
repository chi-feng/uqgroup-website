
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
			$('#nav-wrap').css({ 'position': 'fixed', 'z-index':3 });
      $('#nav').addClass('stuck');   
      $('#sidebar-wrap, #content').css({'margin-top':'2.25em'});   
      $('#nav .totop').css({'opacity':'1'});   
		} else {
			$('#nav-wrap').css({ 'position': 'relative', 'z-index':0 }); 
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
    
  $('.button-bibtex').click(function() {
    $(this).parent().parent().find('div.bibtex').modal();
  });
  
	$('.button-fulltext').click(function (e) {
    $(this).parent().parent().find('.fulltext').modal();
		return false;
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

/*

*/