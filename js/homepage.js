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
        '<i class="mi">&#xE314;</i>',
        '<i class="mi">&#xE315;</i>'
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

function home_slider(){
    var $slider1 = jQuery('.homeslider');
    if( !$slider1.length ){ return; }
    // Run cycle
$slider1.cycle({
    slides          : '> div.homeslider__item',
    timeout         : 5000,
    speed           : 1000,
    swipe           : true,
    log			    : false,
    prev            : '#main_visual_control1 .cycle_prev',
    next            : '#main_visual_control1 .cycle_next',
    pagerActiveClass: 'is-active',
    pagerTemplate   : '<span></span>'

    //caption         : "#main_visual_caption1",
    //captionTemplate : "<span class='main_caption_text current'>{{slideNum}}</span><span class='main_caption_text slug'>/</span><span class='main_caption_text total'>{{slideCount}}</span>"
});
}

// main visual slider
function main_visual_slider(){

  var $slider = jQuery('.slider');

  if( !$slider.length ){ return; }

  // pre init
  jQuery(document).on('cycle-pre-initialize', $slider, function( event, opts ){

      if(jQuery(event.target).hasClass('main_visual_slider')) {
          // init motion
          //slide_motion($slider.find('.main_visual_item:eq(0)')[0], true);
      }

  });

// Run cycle
$slider.cycle({
      slides          : '> div',
      timeout         : 5000,
      speed           : 1000,
      swipe           : true,
      log			    : false,
      prev            : '#main_visual_control .cycle_prev',
      next            : '#main_visual_control .cycle_next',
      caption         : "#main_visual_caption",
      captionTemplate : "<span class='main_caption_text current'>{{slideNum}}</span><span class='main_caption_text slug'>/</span><span class='main_caption_text total'>{{slideCount}}</span>"
});

  // cycle-before
  $slider.on( 'cycle-before', function(event, opts, currEl, nextEl, fwdFlag)  {
      slide_motion(nextEl, false);
  })

  // motion
  function slide_motion(el, flag){

      var $el_txt = jQuery(el).find('.main_visual_content');
      var y_pos = 0;

      if(flag) {
          TweenMax.set('.main_visual_content', {autoAlpha:1});
      }
/*
      if(is_screen(768)) {
          y_pos = 25;
      } else {
          y_pos = 50;
      }
*/
      y_pos = 25;

      TweenMax.fromTo($el_txt.find('h2'), 1.5, {y:y_pos, autoAlpha:0}, {y: 0, autoAlpha:1, force3D:true, ease: Power1.easeOut});
      TweenMax.fromTo($el_txt.find('p'), 1.5, {y:y_pos, autoAlpha:0}, {y: 0, autoAlpha:1, force3D:true, ease: Power1.easeOut, delay: 0.3});
      TweenMax.fromTo($el_txt.find('a'), 1.5, {y:y_pos, autoAlpha:0}, {y: 0, autoAlpha:1, force3D:true, ease: Power1.easeOut, delay: 0.5});

  }

// Pause on mouseover
jQuery('.main_visual .jt_btn').hover(function(){
    $slider.cycle('pause');
}, function(){
      $slider.cycle('resume');
});

}


main_visual_slider();
home_slider();



var scrollElemToWatch_1 = document.getElementById('post-4295');
var watcher_1 = scrollMonitor.create(scrollElemToWatch_1, -300);	
var rev3 = new RevealFx(scrollElemToWatch_1, {
              revealSettings : {
                bgcolor: '#fcf652',
                direction: 'rl',
                onCover: function(contentEl, revealerEl) {
                  contentEl.style.opacity = 1;
                }
              }
            });

            
rev4 = new RevealFx(scrollElemToWatch_1.querySelector(".post__info"), {
                revealSettings : {
                bgcolor: '#7f40f1',
                direction: 'rl',
                delay: 250,
                onCover: function(contentEl, revealerEl) {
                  contentEl.style.opacity = 1;
                }
              }
      });

      rev5 = new RevealFx(scrollElemToWatch_1.querySelector(".post__image"), {
        revealSettings : {
        bgcolor: '#00000',
        direction: 'rl',
        delay: 150,
        onCover: function(contentEl, revealerEl) {
          contentEl.style.opacity = 1;
        }
      }
});
      
watcher_1.enterViewport(function() {
  //alert('usao');
  rev3.reveal();
  rev4.reveal();
  rev5.reveal();
  watcher_1.destroy();
});