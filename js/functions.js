(function($){
  $('figure.wp-caption.aligncenter').removeAttr('style');
  $('img.aligncenter').wrap('<figure class="center-image" />');
})(jQuery);
