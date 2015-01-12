
$(document).ready(function() {
  
  if ($('#content').height() < $('#sidebar').height()) {
    $('#content').height($('#sidebar').height());
  }

  $('img').on('dragstart', function(event) { event.preventDefault(); });

});
  
$(function() {
	var sticky_navigation_offset_top = $('#nav-wrap').offset().top;
	var sticky_navigation = function(){
		var scroll_top = $(window).scrollTop();
		if (scroll_top > sticky_navigation_offset_top) { 
			$('#nav-wrap').css({ 'position': 'fixed', 'z-index':3 });
      $('#nav').addClass('stuck');   
      $('#sidebar-wrap, #content').css({'margin-top':'2.8em'});   
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
     var speedFactor = -0.4;
     var pos = $(window).scrollTop();
     $('#header').css('backgroundPosition', "50% " + Math.round(($('#header').offset().top - pos) * speedFactor) + "px");
	});	
});

function articlesAttachHover() {

  $(".articles .article").hover(
    function () {
      $(this).find($("div.article-buttons")).addClass('active');
      $(this).find($("a.button")).addClass('active');
      $(this).find($("a.thumbnail")).addClass('thumbnail-active');
    },
    function () {
      $(this).find($("div.article-buttons")).removeClass('active');
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

/*

*/