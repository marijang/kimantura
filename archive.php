<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package kimnaturaV1
 */

get_header();
?>



		<?php if ( have_posts() ) : ?>

			<header class="page__header">
				<?php
				the_archive_title( '<h1 class="page__title">', '</h1>' );
				the_archive_description( '<p class="page__description">', '</p>');
				?>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			$current = 'even';
			while ( have_posts() ) : the_post();
			  if($current == 'even'){
				get_template_part( 'template-parts/content-blog', get_post_type() ); 
				$current = 'odd';
			  }else{
				get_template_part( 'template-parts/content-blog-odd', get_post_type() ); 
				$current = 'even';
			  }
			  
			endwhile;

			//the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>



<?php do_action('b4b_achive_post_after_content'); ?>

<?php
get_sidebar();
get_footer();
