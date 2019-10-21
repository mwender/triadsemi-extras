/* Header Scroll Offset */
(function($){
  const scrollOffset = 72 + 45 + 10;

  // Handle on-page links to anchors
  $( window ).on( 'elementor/frontend/init', function() {
    elementorFrontend.hooks.addFilter( 'frontend/handlers/menu_anchor/scroll_top_distance', function( scrollTop ) {
      return scrollTop - 60;
    } );
  } );

  // Handle links to anchors from other pages
  $( window ).on( 'load', function(){
    let hash = window.location.hash;
    if( hash == '' || hash == '#' || hash == undefined )
      return false;

    let target = $(hash);
    target = target.length ? target : $('[name=' + hash.slice(1) + ']');
    if( target.length ){
      $('html,body').stop().animate({
        scrollTop: target.offset().top - scrollOffset
      }, 'linear');
    }
  });
})(jQuery);