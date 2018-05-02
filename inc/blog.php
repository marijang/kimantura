<?php
/**
 * B4B Blog functions
 *
 * @package kimnaturaV1
 */



/* Exclude some categories */
function exclude_category( $query ) {
    $slugs = array('slider','homepage','sastojci');
    foreach($slugs as $slug){
        $cat = get_category_by_slug($slug); 
        if ($cat instanceof WP_TERM){
            $catIDs[] = $cat->term_id;
        }
        
    }  
    if ( $query->is_home() && $query->is_main_query() ) {
        foreach($catIDs as $cat){
            $query->set( 'cat', '-'.$cat );
        }
        
    }
}
add_action( 'pre_get_posts', 'exclude_category' );


// Remove Gallery Styling
add_filter( 'gallery_style1', 'my_gallery_style', 99 );

function my_gallery_style() {
    return "
";
}
add_filter( 'use_default_gallery_style', '__return_false' );



add_filter( 'post_gallery', 'my_post_gallery', 10, 2 );
function my_post_gallery( $output, $attr) {
    global $post, $wp_locale;

    static $instance = 0;
    $instance++;

    // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( !$attr['orderby'] )
            unset( $attr['orderby'] );
    }

    extract(shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post->ID,
        'itemtag'    => 'dl',
        'icontag'    => 'dt',
        'captiontag' => 'dd',
        'columns'    => 3,
        'size'       => 'thumbnail',
        'include'    => '',
        'exclude'    => ''
    ), $attr));

    $id = intval($id);
    if ( 'RAND' == $order )
        $orderby = 'none';

    if ( !empty($include) ) {
        $include = preg_replace( '/[^0-9,]+/', '', $include );
        $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( !empty($exclude) ) {
        $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    } else {
        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    }

    if ( empty($attachments) )
        return '';

    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment )
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
        return $output;
    }

    $itemtag = tag_escape($itemtag);
    $captiontag = tag_escape($captiontag);
    $columns = intval($columns);
    $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
    $float = is_rtl() ? 'right' : 'left';

    $selector = "gallery-{$instance}";

    $output = apply_filters('gallery_style', "
        <style type='text/css'>
            #{$selector}1 {
                margin: auto;
            }
            #{$selector} 1.gallery-item {
                float: {$float};
                margin-top: 10px;
                text-align: center;
                width: {$itemwidth}%;           }
            #{$selector}1 img {
                border: 2px solid #cfcfcf;
            }
            #{$selector} .gallery-caption {
                margin-left: 0;
            }
        </style>
        <!-- see gallery_shortcode() in wp-includes/media.php -->
        <div id='$selector' class='gallery image-boxes galleryid-{$id}'>");

    $i = 0;
    foreach ( $attachments as $id => $attachment ) {
        $link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);

        $output .= "<{$itemtag} class='gallery-item image-boxes__item'>";
        $output .= "
            <{$icontag} class='gallery-icon'>
                $link
            </{$icontag}>";
        if ( $captiontag && trim($attachment->post_excerpt) ) {
            $output .= "
                <{$captiontag} class='gallery-caption'>
                " . wptexturize($attachment->post_excerpt) . "
                </{$captiontag}>";
        }
        $output .= "</{$itemtag}>";
        if ( $columns > 0 && ++$i % $columns == 0 )
            $output .= '<br style="clear: both" />';
    }

    $output .= "
            <br style='clear: both;' />
        </div>\n";

    return $output;
}



// Add single post after content
add_action('b4b_single_post_after_content', 'b4b_blog_post_woocommerce_related_products');
add_action('b4b_achive_post_after_content', 'b4b_blog_post_woocommerce_related_products');

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
add_action('woocommerce_after_single_product_summary','b4b_blog_post_woocommerce_related_products');



if ( ! function_exists( 'b4b_blog_post_woocommerce_related_products' ) ) :
	/**
	 * Prints related products on blog post
	 */
	function b4b_blog_post_woocommerce_related_products() {
        global $post,$product;
        if (is_product()){
            // Join all 
            $upsell  = $product->get_upsell_ids();
            $cross   = $product->get_cross_sell_ids();
            $related = wc_get_related_products($product->get_id());
            $category = array();
            $title =  __('Upsale proizvodi','b4b');
            $productIDs = array_unique (array_merge ($upsell , $cross,$related));
            if(count($productIDs)<3){
                //$related = wc_get_related_products($product->get_id());
                // wc_get_product_ids_on_sale
                // wc_get_related_products
                //var_dump($related);wc_get_product_category_list
                $category = wc_get_product_cat_ids($product->get_id());
                $args1 = array(
                    'post_type' => 'product',
                    'posts_per_page'=>5,
                    'meta_key' => 'total_sales',
                    'orderby' => 'meta_value_num',
                    'post_status' => 'publish',
                    /*
                    'tax_query'             => array(           
                        array(
                            'taxonomy'      => 'product_cat',
                            'field'         => 'term_id', //This is optional, as it defaults to 'term_id'
                            'terms'         => $category ,
                            'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
                        )
                    )*/
                );
                $categorylist = get_posts( $args1 );
                $category = array();
                foreach($categorylist as $cat){
                    $category[] = $cat->ID;
                }
            }
            $productIDs = array_unique (array_merge ($upsell , $cross,$related,$category));
        }else{
            $productIDs = get_post_meta($post->ID,'custom_productIds',true);
            $title =  __('Vezani proizvodi','b4b');
        }
        
		if ($productIDs == ''){
			$productIDs = array(0);
			$args = array(
				'post_type' => 'product',
				'posts_per_page'=>5,
				'meta_key' => 'total_sales',
                'orderby' => 'meta_value_num',
                'post_status' => 'publish'
			);
			$title =  __('Naši najprodavaniji proizvodi','b4b');
		}else{
            if(empty($args)){
                $args = array(
                    'post_type' => 'product',
                    'post__in' => $productIDs,
                    'post_status' => 'publish'
                );
            }
			
			
        }
        
        // Always same title
        $title =  __('Naši najprodavaniji proizvodi','b4b');
        
		$loop = new WP_Query( $args );
		require( locate_template( 'template-parts/content-related-products.php' ) );
		wp_reset_query(); 
		wp_reset_postdata();
	}
endif;


if ( ! function_exists( 'b4b_woocommerce_after_main_content' ) ) {
	/**
	 * Afer Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function b4b_woocommerce_after_main_content() {		
		$args = array( 'posts_per_page' => '2' );
        echo '<div class="section section__blog-lastest section--fluid">';
        echo '<div class="section__content">';
        echo '<h3 class="section__title">'.__('Zadnje novosti','b4b').'</h3>';   
        // The Query
        query_posts( $args );
        // The Loop
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
        wp_reset_postdata();
        echo '</div>';
        echo '</div>';
        // Reset Query
        wp_reset_query();
	}
}
add_action( 'woocommerce_after_main_content', 'b4b_woocommerce_after_main_content', 40 );
add_action('b4b_single_post_after_content', 'b4b_woocommerce_after_main_content', 40 );