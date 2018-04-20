jQuery(window).load(function() {



jQuery('.products__slider').owlCarousel({
    margin:0,
    loop:true,
    autoWidth:true,
   // autoHeight:true,
    items:3,
    nav:true,
    dots:true,
    navText: [
        "<i class='fa fa-caret-left'></i>",
        "<i class='fa fa-caret-right'></i>"
      ],
      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 2
        },
        1000: {
          items: 2
        }
      },
      autoplay: true,
      autoplayHoverPause: true,
})



});