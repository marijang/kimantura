<?php
/**
 * The template for displaying all pages
 * Template Name: Contact
 *
 * This is the template that displays Contact by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package b4b
 */

get_header();
?>
<section class="section">
   
        <header class="section__header">
                <?php the_title( '<h1 class="section__title">', '</h1>' ); ?>
                <?php the_subtitle( '<p class="section__description">', '</p>' ); ?>
        </header><!-- .entry-header -->
  
    <div class="section__content">
       <?php the_content(); ?>
    </div>
</section>
<?php
get_sidebar();
get_footer();
