<?php
/**
 * Template part for displaying page content in homepage.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package kimnaturaV1
 */

?>
<section class="section section--primary section--fluid">
    <article id="post-<?php the_ID(); ?>" <?php post_class('article'); ?>>
        <header class="article__header">
            <?php the_title( '<h1 class="article__title article__title--center">', '</h1>' ); ?>
            <?php the_subtitle( '<p class="article__description">', '</p>' ); ?>
        </header><!-- .entry-header -->
        <div class="article__content-wrap article__content-wrap--columns">
     
        <div class="article__content">
            <?php
            the_content();

            wp_link_pages( array(
                'before' => '<div class="article__links">' . esc_html__( 'Pages:', 'kimnaturav1' ),
                'after'  => '</div>',
            ) );
            ?>
            <a href="<?php echo  esc_url( get_permalink() )?>" rel="bookmark">Saznaj više</a>
        </div><!-- .entry-content -->
        <div class="article__image">
            <?php kimnaturav1_post_thumbnail(); ?>
        </div>
            </div><!-- .article__content -->

        
    </article><!-- #post-<?php the_ID(); ?> -->
</section>
