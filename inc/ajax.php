<?php
/**
 * Account Modifications
 *
 * @link https://woocommerce.com/
 *
 * @package b4b
 */

//https://medium.com/@AnthonyBudd/wp-ajax-97d8f1d83e26



Class Example extends WP_AJAX
{
    protected $action = 'example';

    protected function run()
    {
     
           
        $args = array(
            'post_type' => 'product',
            'orderby' => 'date', // we will sort posts by date
            'order'	=> $_POST['date'] // ASC или DESC
        );
     
        // for taxonomies / categories
        if( isset( $_POST['categoryfilter'] ) )
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'id',
                    'terms' => $_POST['categoryfilter']
                )
            );
     
        // create $args['meta_query'] array if one of the following fields is filled
        if( isset( $_POST['price_min'] ) && $_POST['price_min'] || isset( $_POST['price_max'] ) && $_POST['price_max'] || isset( $_POST['featured_image'] ) && $_POST['featured_image'] == 'on' )
            $args['meta_query'] = array( 'relation'=>'AND' ); // AND means that all conditions of meta_query should be true
     
        // if both minimum price and maximum price are specified we will use BETWEEN comparison
        if( isset( $_POST['price_min'] ) && $_POST['price_min'] && isset( $_POST['price_max'] ) && $_POST['price_max'] ) {
            $args['meta_query'][] = array(
                'key' => '_price',
                'value' => array( $_POST['price_min'], $_POST['price_max'] ),
                'type' => 'numeric',
                'compare' => 'between'
            );
        } else {
            // if only min price is set
            if( isset( $_POST['price_min'] ) && $_POST['price_min'] )
                $args['meta_query'][] = array(
                    'key' => '_price',
                    'value' => $_POST['price_min'],
                    'type' => 'numeric',
                    'compare' => '>'
                );
     
            // if only max price is set
            if( isset( $_POST['price_max'] ) && $_POST['price_max'] )
                $args['meta_query'][] = array(
                    'key' => '_price',
                    'value' => $_POST['price_max'],
                    'type' => 'numeric',
                    'compare' => '<'
                );
        }
     
     
        // if post thumbnail is set
        if( isset( $_POST['featured_image'] ) && $_POST['featured_image'] == 'on' )
            $args['meta_query'][] = array(
                'key' => '_thumbnail_id',
                'compare' => 'EXISTS'
            );
     
        $query = new WP_Query( $args );
     
        if( $query->have_posts() ) :
            while( $query->have_posts() ): $query->the_post();
                echo '<h2>' . $query->post->post_title . 'sss</h2>';
            endwhile;
            wp_reset_postdata();
        else :
            echo 'No posts found';
        endif;
    }

    protected function run1(){
       // echo "Success!";
        //products?category=17&attribute=pa_color&attribute_term=22&attribute=pa_size&attribute_term=24&re
        $args = array(
            'post_type' => 'product',
            'product_cat' => 'sapuni',
            'tax_query' => array(
                array(
                    'relation' => 'OR',
                    array(
                        'taxonomy' => 'pa_color',
                        'field'    => 'term_id',
                        'terms'    => array( 'red' ),
                    ),
                    array(
                        'taxonomy' => 'pa_size',
                        'field'    => 'term_id',
                        'terms'    => array( 'Long' ),
                    ),
                ),
            ),
            );
            $products = new WP_Query( $args );



            $args = array(
                'orderby' => 'date', // we will sort posts by date
                'order'	=> $_POST['date'] // ASC или DESC
            );
         
            // for taxonomies / categories
            if( isset( $_POST['categoryfilter'] ) )
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'category',
                        'field' => 'slug',
                        'terms' => 'sapuni'
                    )
                );
            
            $products = new WP_Query( $args );
            $this->JSONResponse($products->get_posts());
            print_r($products);
    }
}
Example::listen();

add_action( 'wp_ajax_nopriv_ajax_pagination', 'my_ajax_pagination1' );
add_action( 'wp_ajax_ajax_pagination', 'my_ajax_pagination1' );

function my_ajax_pagination1(){
    echo get_bloginfo( 'title' );
    die();
}

 
add_action( 'wp_ajax_nopriv_ajax_pagination1', 'my_ajax_pagination' );
add_action( 'wp_ajax_ajax_pagination1', 'my_ajax_pagination' );

function my_ajax_pagination() {
    $query_vars = json_decode( stripslashes( $_POST['query_vars'] ), true );

    $query_vars['paged'] = $_POST['page'];


    $posts = new WP_Query( $query_vars );
    $GLOBALS['wp_query'] = $posts;

    add_filter( 'editor_max_image_size', 'my_image_size_override' );

    if( ! $posts->have_posts() ) { 
        get_template_part( 'content', 'none' );
    }
    else {
        while ( $posts->have_posts() ) { 
            $posts->the_post();
            get_template_part( 'content', get_post_format() );
        }
    }
    remove_filter( 'editor_max_image_size', 'my_image_size_override' );

    the_posts_pagination( array(
        'prev_text'          => __( 'Previous page', 'twentyfifteen' ),
        'next_text'          => __( 'Next page', 'twentyfifteen' ),
        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>',
    ) );

    //die();
}

function my_image_size_override() {
    return array( 825, 510 );
}


add_action( 'wp_ajax_button_click', 'user_clicked' );
function user_clicked() {
    update_user_meta( get_current_user_id(), 'clicked_link', 'yes' );
    echo 'ok';
    die();
}

function misha_filter_function(){
	$args = array(
		'orderby' => 'date', // we will sort posts by date
		'order'	=> $_POST['date'] // ASC или DESC
	);
 
	// for taxonomies / categories
	if( isset( $_POST['categoryfilter'] ) )
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'category',
				'field' => 'id',
				'terms' => $_POST['categoryfilter']
			)
		);
 
	// create $args['meta_query'] array if one of the following fields is filled
	if( isset( $_POST['price_min'] ) && $_POST['price_min'] || isset( $_POST['price_max'] ) && $_POST['price_max'] || isset( $_POST['featured_image'] ) && $_POST['featured_image'] == 'on' )
		$args['meta_query'] = array( 'relation'=>'AND' ); // AND means that all conditions of meta_query should be true
 
	// if both minimum price and maximum price are specified we will use BETWEEN comparison
	if( isset( $_POST['price_min'] ) && $_POST['price_min'] && isset( $_POST['price_max'] ) && $_POST['price_max'] ) {
		$args['meta_query'][] = array(
			'key' => '_price',
			'value' => array( $_POST['price_min'], $_POST['price_max'] ),
			'type' => 'numeric',
			'compare' => 'between'
		);
	} else {
		// if only min price is set
		if( isset( $_POST['price_min'] ) && $_POST['price_min'] )
			$args['meta_query'][] = array(
				'key' => '_price',
				'value' => $_POST['price_min'],
				'type' => 'numeric',
				'compare' => '>'
			);
 
		// if only max price is set
		if( isset( $_POST['price_max'] ) && $_POST['price_max'] )
			$args['meta_query'][] = array(
				'key' => '_price',
				'value' => $_POST['price_max'],
				'type' => 'numeric',
				'compare' => '<'
			);
	}
 
 
	// if post thumbnail is set
	if( isset( $_POST['featured_image'] ) && $_POST['featured_image'] == 'on' )
		$args['meta_query'][] = array(
			'key' => '_thumbnail_id',
			'compare' => 'EXISTS'
		);
 
	$query = new WP_Query( $args );
 
	if( $query->have_posts() ) :
		while( $query->have_posts() ): $query->the_post();
			echo '<h2>' . $query->post->post_title . '</h2>';
		endwhile;
		wp_reset_postdata();
	else :
		echo 'No posts found';
	endif;
 
	die();
}
 
 