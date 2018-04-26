
$inputs = function () {
  return jQuery('.c_input input');
};

function setInputActiveState(input) {
  jQuery(input).parent().addClass('active');
}
function unsetInputActiveState(input) {
  var $this = jQuery(input);
  var $formGroup = $this.parent();

  // remove active state if input is empty
  if (!$this.val()) $formGroup.removeClass('active');
}

var initializeInputs = function () {
  $inputs().each(function (index, input) {
    var $input = jQuery(input);

    // shouldn't be inited twice
    if ($input.data('c_input')) return;

    // set flag
    $input.data('c_input', true);

    $input.on({
      focusin: function focusin() {
        setInputActiveState(input);
      },
      focusout: function focusout() {
        unsetInputActiveState(input);
      }
    });

    if (input.value) setInputActiveState(input);
  });
}



  //init inputs
  initializeInputs();


  (function() {
 
    window.inputNumber = function(el) {
  
      var min = el.attr('min') || false;
      var max = el.attr('max') || false;
  
      var els = {};
  
      els.dec = el.prev();
      els.inc = el.next();
  
      el.each(function(i,item) {
        //console.log(item);
        init(jQuery(item));
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
  //inputNumber(jQuery('.input__number'));

  jQuery(document).ready(function(){
    jQuery('img').materialbox();
    jQuery('select').formSelect();
    jQuery('input[type="checkbox"]').addClass("filled-in");
    jQuery('input[type="radio"]').addClass("with-gap");
    jQuery('.collapsible').collapsible();
    jQuery('.carousel').carousel();
    
  });
        
