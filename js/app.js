var allPanels = jQuery('.product-categories > ul').hide();
  
jQuery('.product-categories > ul > a').click(function() {
  jQuery(this).parent().next().slideToggle();
  return false; 
});


jQuery('.cat-parent>a').bind('click', function(e){

    jQuery(this).parent().find('ul').slideToggle('fast');  // apply the toggle to the ul
    jQuery(this).parent().toggleClass('is-expanded');
    e.preventDefault();
});

