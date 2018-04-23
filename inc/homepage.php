<?php
/**
 * Functions which enhance the Homepage by B4B
 * 
 * @package b4b
 * 
 */




function b4b_homepage_adding_styles() {
   // if ( is_page_template( 'homepage.php' ) ){
        //wp_register_style('flexslider1', theme_url('/plugins/flexslider.css', __FILE__));
        wp_register_style('flexslider2', theme_url('/plugins/owl.carousel.min.css', __FILE__));
        wp_register_style('flexslider3', get_template_directory_uri() .'/plugins/owl.theme.default.css');
        wp_enqueue_style('flexslider2');
        wp_enqueue_style('flexslider3');
    //}
}
add_action( 'wp_enqueue_scripts', 'b4b_homepage_adding_styles' ); 



function wpb_adding_styles() {
wp_register_style('my_stylesheet', get_template_directory_uri() .'/plugins/owl.carousel.min.css');
wp_enqueue_style('my_stylesheet');
}
add_action( 'wp_enqueue_scripts', 'wpb_adding_styles' );  


function b4b_homepage_adding_js() {
	wp_enqueue_script( 'kimnaturav1-collapse', get_template_directory_uri() . '/js/application.js', array(), '20151215', true );
    if ( is_page_template( 'homepage.php' ) ){
        //wp_register_script('flexslider', theme_url('plugins/jquery.flexslider-min.js', __FILE__), array('jquery'),'1.1', true);   
		wp_register_script('owlslider', get_template_directory_uri() .'/plugins/owl.carousel.min.js'); 
		wp_enqueue_script('productslider2', get_template_directory_uri() . '/plugins/jquery.cycle2.min.js', array(), '20151215', true );
        wp_enqueue_script('productslider', get_template_directory_uri() . '/js/homepage.js', array(), '20151215', true );
        wp_enqueue_script('owlslider');
       
    }
}
    
add_action( 'wp_enqueue_scripts', 'b4b_homepage_adding_js' );  


if ( ! function_exists( 'b4b_homepage_after_main_content' ) ) {
	/**
	 * Afer Content.
	 *
	 * Wraps all homepage content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function b4b_homepage_after_main_content() {		
		$args = array( 'numberposts' => '2' ,'category_name' => 'blog');
		echo '<div class="section">';
        echo '<h1 class="section__title section__title--center">'.__('Last news').'</h1>';
		global $wpdb,$post;
		/*
		$result1 = $wpdb->get_results("
			SELECT $wpdb->posts.* 
			FROM   $wpdb->posts 
			WHERE  post_type = 'post' 
			AND    post_status = 'publish'
			and    cat_id != 35
			limit 1
		");
		*/
		$result = get_posts( $args ) ;
		foreach($result as $post):
		  setup_postdata($post);
		  get_template_part( 'template-parts/content-blog', get_post_type() ); 
		endforeach;

		wp_reset_postdata();	
        echo '</div>';

	}
}
add_action( 'b4b_homepage_after_main_content', 'b4b_homepage_after_main_content', 40 );


