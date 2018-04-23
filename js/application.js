
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

