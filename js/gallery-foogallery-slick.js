//FooGallery FooGallery Slick template script
//Add any javascript that will be needed by your gallery template. This will be output to the frontend

(function($){
  if ( ! $.fn.slick ) {
    return;
  }

  $(function() {
    console.log( $('.foogallery-foogallery-slick, .foogallery-foogallery-slick-slider-sync') );
    $('.foogallery-foogallery-slick, .foogallery-foogallery-slick-slider-sync').slick();

  });

})(jQuery);
