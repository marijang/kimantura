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
echo '<div class="homeslider__wrapper">
	   
	   <div id="main_visual_slider1" class="homeslider jt_full_section" data-cycle-fx="scrollHorz">';
		while ( have_posts() ) :

			the_post();

			get_template_part( 'template-parts/content', 'homeslider' );

			
		endwhile; // End of the loop.
		while ( have_posts() ) :

			the_post();

			get_template_part( 'template-parts/content', 'homeslider' );

			
		endwhile; // End of the loop.
		echo '<div class="cycle-pager homeslider__pager"></div>
		</div>
		<div class="cycle_controler" style="display:none;">
        <div lang="en" id="main_visual_caption11" class="cycle_caption"></div>

        <div id="main_visual_control1" class="cycle_control">
            <div class="cycle_btn cycle_prev">prev</div>
            <div class="cycle_btn cycle_next">next</div>
        </div><!-- .cycle_control -->
	</div><!-- .cycle_controler -->
	
	<div class="scroller">
	<div class="mouse">
		<div class="ball"></div>
	</div>
</div>
		</div>';
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
		?>
		
		<section class="slider__wrapper">
		<div id="main_visual_slider" class="slider jt_full_section">
		<?php
		if ( $blog_query->have_posts() ) :  
			//$blog_query->the_post(); 
		while ( $blog_query->have_posts() ) : $blog_query->the_post();  
			get_template_part( 'template-parts/content', 'slider01' );
		endwhile; // End of the loop.
	
		endif;
		$wp_query = $temp_query;
		wp_reset_postdata(); 
		?>
		</div>
		<div class="cycle_controler">
        <div lang="en" id="main_visual_caption" class="cycle_caption"></div>

        <div id="main_visual_control" class="cycle_control">
            <div class="cycle_btn cycle_prev">prev</div>
            <div class="cycle_btn cycle_next">next</div>
        </div><!-- .cycle_control -->
    </div><!-- .cycle_controler -->
</section>


<section class="section newsletter" style="background-image:url(<?php echo b4b_get_theme_image('newsletter.png'); ?>);">

  <?php
  echo '<h2 class="newsletter__title">'.__('Prijavite se na naš newsletter').'</h2>'; 
  echo do_shortcode('[mc4wp_form id="4266"]');
  ?>
</section>

<div class="section section--primary">
		<div class="c_input form-group">
		    <label class="c_input__placeholder control-label">Enter your request</label>
		    <input name="q" class="c_input__input form-control" type="text">
		    <button class="footer__btn footer__btn-search" type="submit">
				<svg class="icon-search "><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-search"></use></svg>
			</button>
		</div>




</div>


<?php
get_sidebar();
get_footer();
