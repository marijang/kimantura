<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package kimnaturaV1
 */

?>
<?php do_action('b4b_checkout_before'); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('page__article'); ?>>
    <?php do_action('b4b_checkout_content_before'); ?>

		<?php
		the_content();
		?>

    <?php do_action('b4b_checkout_content_after'); ?>
</article><!-- #post-<?php the_ID(); ?> -->
<?php do_action('b4b_checkout_after'); ?>