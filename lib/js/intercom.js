/* Intercom functionality */
(function($){
  $('body').on('click','.open-intercom',function(e){
    e.preventDefault();
    console.log('Opening Intercom...');
    Intercom('show');
  });
})(jQuery);