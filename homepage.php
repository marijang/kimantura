<?php
/**
 * The template for displaying all pages
 * Template Name: Homepage
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package kimnaturaV1
 */

get_header();
?>


		<?php

		while ( have_posts() ) :

			the_post();

			get_template_part( 'template-parts/content', 'homepage' );

			
		endwhile; // End of the loop.

        // Slider proizvoda
		do_action('b4b_homepage_section');

		
		// Blogovi
		$blog_query = new WP_Query( array(
			'post_type' => 'post',
			'category_name' => 'homepage'
			) );
		$temp_query = $wp_query;
		$wp_query = null;
		$wp_query = $blog_query;
		//print_r($blog_query);

		if ( $blog_query->have_posts() ) :  
			//$blog_query->the_post(); 
		while ( $blog_query->have_posts() ) : $blog_query->the_post();  
		    get_template_part( 'template-parts/content', 'section' );
	    endwhile; // End of the loop.
	
		endif;
	    $wp_query = $temp_query;
	    wp_reset_postdata(); 




			
		
		do_action('b4b_homepage_after_main_content');
	


		// sastojci
		$blog_query = new WP_Query( array(
			'post_type' => 'post',
			'category_name' => 'sastojci'
			) );
		$temp_query = $wp_query;
		$wp_query = null;
		$wp_query = $blog_query;
		//print_r($blog_query);

		if ( $blog_query->have_posts() ) :  
			//$blog_query->the_post(); 
		while ( $blog_query->have_posts() ) : $blog_query->the_post();  
			get_template_part( 'template-parts/content', 'section' );
		endwhile; // End of the loop.
	
		endif;
		$wp_query = $temp_query;
		wp_reset_postdata(); 



		echo do_shortcode('[mc4wp_form id="4266"]');
		?>



<?php
get_sidebar();
get_footer();
