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

(function($){
	function test(){

    console.log(ajaxpagination.query_vars);
    $.ajax({
        url: ajaxpagination.ajaxurl,
        type: 'post',
        data: {
            action: 'ajax_pagination',
            query_vars: ajaxpagination.query_vars,
            //page: page
        },
        beforeSend: function() {
            $(document).scrollTop();
            $('body').prepend( '<div class="page-content" id="loader"><h3>Loading New Posts...</h3></div>' );
        },
        success: function( html ) {
            console.log(html);
            
            $('#main #loader').remove();
            $('body').prepend( html );
        }
    })
    
}
//test();

var setValue = function(){
  var total = '';
$.each($('input[name="product_cat[]"]:checked'), function( index, item ){ 
  value = $(this).val();
  $target = $('input[name="product_cat"]');
  if(index==0){
    total = value;
  }else{
    total = total + ','+ value;
  }
  $target.val(total);
});
}

$('input[name="product_cat[]"]').on('click',function(){
   setValue();

   // similar behavior as an HTTP redirect
//window.location.replace("http://stackoverflow.com");

// similar behavior as clicking on a link
if($('input[name="product_cat"]').val()!=''){
  window.location.href = "/shop/?category="+$('input[name="product_cat"]').val();
}
  
});





	
})(jQuery);