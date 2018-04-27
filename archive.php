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
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content-blog', get_post_type() );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>


<div class="best-selling-products">
    <h2>
	<?php echo __( 'Naši najprodavaniji proizvodi', 'b4b-woo-most-sell-products' );?>
	</h2>
    <div class="best-selling-products__content">
	<?php
	$args = array(
		'post_type' => 'product',
		'meta_key' => 'total_sales',
		'orderby' => 'meta_value_num',
		'posts_per_page' => 4,
	);
	$loop = new WP_Query( $args );
	while ( $loop->have_posts() ) : $loop->the_post(); 
	   global $product; 
	?>
    <div class="best-selling-products__item">
        <a id="id-<?php the_id(); ?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="featured-link">
		<?php 
			$item = new WC_Product($loop->post->ID); 
			//$_product->get_regular_price();
			//$_product->get_sale_price();
			//$_product->get_price();
			//$price = wc_price(wc_get_price_including_tax($loop->post->ID,$item->get_price()));
			//$price = wc_get_price_including_tax($item);
			//$price = wc_price($product->get_price_including_tax(1,$product->get_price()));
			$price = wc_price(wc_get_price_including_tax($item ));
		    if (has_post_thumbnail( $loop->post->ID )) 
			   //echo get_the_post_thumbnail($loop->post->ID); 
			//   echo get_the_post_thumbnail( $loop->post->ID, 'full' ,array('class'=>'featured-link__image'));
			echo get_the_post_thumbnail( $loop->post->ID, 'shop_catalog' ,array('class'=>'featured-link__image'));
			
			else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="product placeholder Image" width="65px" height="115px" />'; 
		?>
        
		   <h4 class="featured-link__title"><?php the_title(); ?></h4>
		   <div class="featured-link__movable">

					<strong class="featured-link__price"><?php echo $price ?></strong>
					<?php
					if ($product->is_type( 'variable' )) 
{
	$available_variations = $product->get_available_variations();
	print_r($available_variations);

	$attributes =  $product->get_variation_attributes() ;

	if ( $attributes [ 'Pakovanje' ] ) {
		$colour = [ 'attribute_pakovanje' => $attributes [ 'Pakovanje'] ];
		echo '<h5>Pakiranje</h5>';
		echo '<p>';
		foreach ($attributes [ 'Pakovanje' ] as $variation){
			echo ''.$variation.'';
		   }
	    echo '<p>';
		//echo wc_get_formatted_variation ( $colour );
	}
/*
    foreach ($available_variations as $key => $value) 
    { 
		//print_r($value);
		if ( $value [ 'attribute_akovanje' ] ) {
			$colour = [ 'attribute_pakovanje' => $value [ 'attribute_pakovanje'] ];
			echo wc_get_formatted_variation ( $colour );
		}
	   //echo '<h5>'.$key.'</h5>';
	   
	   foreach ($value as $variation){
		//echo '<p>'.$variation.'</p>';
	   }
	   
	}
	*/
}
?>


				

                    <div class="featured-link__button">Idi na proizvod</div>
            </div>
       </a>
    </div>
    <?php endwhile; ?>
    </div>
<?php wp_reset_query(); ?>


</div>

<?php
get_sidebar();
get_footer();
