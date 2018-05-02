<?php
/**
 * Template part for displaying related products on page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package b4b
 */


 //global $loop

 
?>
<section class="section  page__related-products">
    <?php if (is_front_page()) :?>
    <h3 class="section__title section__title--center"><?php echo  $title;?></h3>
    <?php else :?>
    <h3 class="section__title"><?php echo  $title;?></h3>
    <?php endif;?>
    <div class="products__most-selling">
	   
	    <div class="products__slider-wrapper">
	       <div class="owl-carousel owl-theme products__slider">
           <?php
	        if ( $loop->have_posts() ):
            while ( $loop->have_posts() ) : $loop->the_post(); 
			   global $product; 
		    ?>
		<div class="item" style="">

   
        <a id="id-<?php the_id(); ?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="featured-link">
        <?php 
        if (has_post_thumbnail( $loop->post->ID )) 
        echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog',array('class'=>'featured-link__image')); 
        else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="product placeholder Image" width="65px" height="115px" />'; 
        ?>
          <h4 class="featured-link__title"><?php the_title(); ?></h4>
          <div class="featured-link__movable">
					<strong class="featured-link__price">
                        <?php echo $product->get_price_html();?>
                    </strong>
                    <div class="featured-link__button">Idi na proizvod</div>
            </div>
        </a>
			
		</div>
		<?php endwhile; 
		endif;
		
		?>
           </div>
		</div>
	</div>
</section>