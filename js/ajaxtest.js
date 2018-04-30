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



	
})(jQuery);
