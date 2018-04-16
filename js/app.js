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




(function() {
 
  window.inputNumber = function(el) {

    var min = el.attr('min') || false;
    var max = el.attr('max') || false;

    var els = {};

    els.dec = el.prev();
    els.inc = el.next();

    el.each(function() {
      init($(this));
    });

    function init(el) {

      els.dec.on('click', decrement);
      els.inc.on('click', increment);

      function decrement() {
        var value = el[0].value;
        value--;
        if(!min || value >= min) {
          el[0].value = value;
        }
      }

      function increment() {
        var value = el[0].value;
        value++;
        if(!max || value <= max) {
          el[0].value = value++;
        }
      }
    }
  }
})();
//FontAwesomeConfig = { searchPseudoElements: true };
inputNumber($('.input__number'));