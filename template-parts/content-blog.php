<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package kimnaturaV1
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('page__article post__item'); ?>>
    
	<div class="post__info">
	    <?php
		    if ( is_singular() ) :
			   the_title( '<h2>','</h2>' );
			else :
				the_title( '<h2 class="post__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;
			if ( 'post' === get_post_type() ) :
		?>
		    <div class="entry-meta" style="display:none;">
	    	<?php
					kimnaturav1_posted_on();
					kimnaturav1_posted_by();
			?>
		    </div><!-- .entry-meta -->
		<?php endif; ?>
	   <p>
		<?php
		 if( has_excerpt() ){
			$content = the_excerpt();
		} else {
			the_content( sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'kimnaturav1' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			) );
		}
		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'kimnaturav1' ),
			'after'  => '</div>',
		) );
		?>
		</p>
	   <a href="<?php echo  esc_url( get_permalink() )?>" rel="bookmark">Saznaj više</a>
	   <?php //kimnaturav1_entry_footer(); ?>
	   </div>
	<div class="post__image">
	   <?php kimnaturav1_post_thumbnail(); ?>
	</div>




</article><!-- #post-<?php the_ID(); ?> -->
