
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
    
$('a[href*="#"]').click(function(event){
	event.preventDefault();
	var parts = this.href.split("#");
	var trgt = parts[1];
	var target_offset = $("#"+trgt).offset();
	var target_top = target_offset.top - 55;
	$('html, body').animate({scrollTop:target_top}, 500);
});

$(window).resize(function() {
  /*
  if ($(window).width() < 1100) {
    $('#header-wrap, #content-wrap, #footer-wrap, #nav').css({'width':'50em'}, 500);
    $('.logos img').css({'height':'3em'});
    $('#sidebar-wrap').css({'opacity': '0.0'});
  }
  else {
    $('#header-wrap, #content-wrap, #footer-wrap, #nav').css({'width':'67em'}, 500);
    $('.logos img').css({'height':'4em'});  
    $('#sidebar-wrap').css({'opacity': '1.0'});
  }
  */
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

function articlesAttachHover() {
  $('textarea.bibtex').click(function() { $(this).select(); });
  $("#articles .article").hover(
    function () {
      $(this).find($("a.button")).addClass('active');
    },
    function () {
      $(this).find($("a.button")).removeClass('active');
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
