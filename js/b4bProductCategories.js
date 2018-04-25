var allPanels = jQuery('.shop-categories > ul').show();
  
jQuery('.shop-categories > ul > a').on('click',function(e) {
  jQuery(this).parent().next().slideToggle();
  e.preventDefault();
  return false; 
});


jQuery('.shop-categories>a,.shop-categories__icon').on('click', function(e){
    e.preventDefault();
    jQuery(this).parent().parent().find('ul').slideToggle('fast');  // apply the toggle to the ul
    jQuery(this).parent().toggleClass('is-expanded');
    
});