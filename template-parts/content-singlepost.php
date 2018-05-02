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
	<div class="page__content-wrap">
	<div class="page__content-sidebar">
	     <?php get_template_part( 'template-parts/content', 'share'); ?>
    </div>
	<div class="page__content page__content--intendent" id="page-content">
		<?php
		the_content();
		?>
	</div><!-- .entry-content -->
	</div><!-- .entry-content -->


</article><!-- #post-<?php the_ID(); ?> -->

<?php do_action('b4b_single_post_after_content'); ?>
