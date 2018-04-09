<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package kimnaturaV1
 */

?>

<article id="post-<?php the_ID(); ?>" class="page__article">
	<header class="page__header">
   
   
      <h1 class="page__title">
      <?php the_title('<span class="page__title-main">', '</span>') ; ?>
      
	  </h1>
	  <?php the_subtitle( '<p class="page__description">', '</p>' ); ?>
	</header><!-- .entry-header -->
    <div class="page__image ">
  
	    <?php b4b_post_image(); ?>
    </div>
	<div class="page__content">
		<?php
		the_content();

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'kimnaturav1' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer" style="display:none;">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'kimnaturav1' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
