<?php if (!defined('INCLUDE_GUARD')) { header("HTTP/1.0 403 Forbidden"); die(); } ?>


<script type="text/javascript">

$(document).ready(function() {
  $('table tr:even').addClass('even');
  $('table tr:odd').addClass('odd');
  $('.input-date').datepicker({ dateFormat: "M d, yy" });
  $('.confirm').click(function(){return confirm("Are you sure?");});
  var article_auto_populate = '<div id="auto-populate" class="clearfix">\
  <p>Auto-populate from entry: Author, A.B., Author, C.D. "Title." Journal Name: Volume Pages (Year)</p>\
  <textarea class="auto-populate"></textarea><br />\
  <input type="button" class="btn" id="auto-populate-button" value="Parse" />\
  </div>';
  $('form.create-article fieldset').prepend(article_auto_populate);
  $('#auto-populate-button').click(function() {
    parse_article($('textarea.auto-populate').val());
  });
});



</script>
</body>
</html>