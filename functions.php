<?php
/**
 * kimnaturaV1 functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package kimnaturaV1
 */

/**
 * Bit4Bytest  functions.
 *
 * @package bit4bytes
 */


//remove_filter( 'the_content', 'wpautop' );
//add_filter( 'the_content', 'wpautop' , 12);
require get_template_directory() . '/inc/B4B.php';
$B4BWP = new B4BWP;

function b4b_adding_js($name,$local='') {
	$scripts = array();
    switch($name){
		case 'carousel' :
		   $scripts['owl-script']['name'] = 'owl-script';
		   $scripts['owl-script']['location'] = get_template_directory_uri() .'/plugins/owl.carousel.min.js';
		   $scripts['owl-script']['version'] = '1.4';
		   $scripts['owl']['name'] = 'owl-style1';
		   $scripts['owl']['location'] = get_template_directory_uri() .'/plugins/owl.carousel.min.css';
		   $scripts['owl']['version'] = '1.55';
		   $scripts['owl-style2']['name'] = 'owl-style2';
		   $scripts['owl-style2']['location'] = get_template_directory_uri() .'/plugins/owl.theme.default.css';
		   $scripts['owl-style2']['version'] = '1.1';   
		break;
	}
	if (isset($local)&&$local!=''){
		$scripts['page-custom-'.$name]['name'] = 'page-custom-'.$name;
		$scripts['page-custom-'.$name]['location'] = get_template_directory_uri() .$local;
		$scripts['page-custom-'.$name]['version'] = '1.4';
	}
	return $scripts;
}
    




add_shortcode( 'b4b_image_dir', function( $atts ){
    return get_template_directory_uri() . '/img/' . $atts['image'];
});


function b4b_get_theme_image($imageName){
	return get_template_directory_uri() . '/img/' . $imageName;
}


function exclude_category( $query ) {
    if ( $query->is_home() && $query->is_main_query() ) {
        $query->set( 'cat', '-35' );
    }
}
add_action( 'pre_get_posts', 'exclude_category' );

function theme_url(){
	return get_template_directory_uri();
}

function modify_read_more_link() {
	return '';
    return '<a class="more-link" href="' . get_permalink() . '">Your Read More Link Text</a>';
}
add_filter( 'the_content_more_link', 'modify_read_more_link' );


function b4b_litetext_shortcode( $atts, $content = null ) {
	return '<p class="litetext attention-grabber ">' . $content . '</p>';
}
add_shortcode( 'litetext', 'b4b_litetext_shortcode' );




function b4b_contentgrid_md( $atts, $content = null ) {
	return '<div class="contentgrid">' . do_shortcode( $content )    . '</div>';
}
add_shortcode( 'content-md', 'b4b_contentgrid_md' );


function b4b_boxes( $atts, $content = null ) {
	return '<div class="boxes">' . do_shortcode( $content )    . '</div>';
}
add_shortcode( 'boxes', 'b4b_boxes' );

function b4b_boxes_item( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'number' => '1',
		'title' => 'title',
	), $atts );

	$o  = '<div class="boxes__item">'; 
	$o .=  '<div class="boxes__number">'.esc_attr($a['number']) .'.</div>';
	$o .=  '<h4>'.esc_attr($a['title']) .'</h4>';
	$o .=  '<p>'.do_shortcode( $content ) .'</p>';
	$o .= '</div>';
	return $o;
}
add_shortcode( 'boxes-item', 'b4b_boxes_item' );

function b4b_imageboxes( $atts, $content = null ) {
	return '<div class="image-boxes">' . do_shortcode( $content )    . '</div>';
}
add_shortcode( 'image-box', 'b4b_imageboxes' );

function b4b_imageboxesitem( $atts, $content = null ) {
	return '<div class="image-boxes__item">' . do_shortcode( $content )    . '</div>';
}
add_shortcode( 'image-box-item', 'b4b_imageboxesitem' );

function the_product_price($product){
	//get the sale price of the product whether it be simple, grouped or variable
	$sale_price = '<span class="new">'.get_post_meta( get_the_ID(), '_price', true).'</span>';
	//get the regular price of the product, but of a simple product
	$regular_price = get_post_meta( get_the_ID(), '_regular_price', true);
	//oh, the product is variable to $sale_price is empty? Lets get a variation price
	if ($regular_price == ""){
		#Step 1: Get product varations
		$available_variations = $product->get_available_variations();
		if($available_variations){
			#Step 2: Get product variation id
			$variation_id=$available_variations[0]['variation_id']; // Getting the variable id of just the 1st product. You can loop $available_variations to get info about each variation.
			#Step 3: Create the variable product object
			$variable_product1= new WC_Product_Variation( $variation_id );
			#Step 4: You have the data. Have fun :)
			$regular_price = $variable_product1->regular_price;
		}
	}
	if(!empty($regular_price)){
		echo '<span class="old">';
	}else{
		echo '<span class="new">';
	}
	
	echo $regular_price;
	echo '</span>';
	if(!empty($sale_price)){ echo '<span class="new">'. $sale_price .' $</span>';}
}
	
// Remove p tags from category description
remove_filter('term_description','wpautop');
add_filter( 'get_the_archive_title', function ( $title ) {

    if( is_category() ) {

        $title = single_cat_title( '', false );

    }
    return $title;
});


if ( ! function_exists( 'b4b_languages_list' ) ) {
function b4b_languages_list(){
    $languages = icl_get_languages('skip_missing=0&orderby=code');
    if(!empty($languages)){
        echo '<div id="language_list"><ul>';
        foreach($languages as $l){
            echo '<li>';
            if($l['country_flag_url']){
                if(!$l['active']) echo '<a href="'.$l['url'].'">';
                echo '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" />';
                if(!$l['active']) echo '</a>';
            }
            if(!$l['active']) echo '<a href="'.$l['url'].'">';
            echo icl_disp_language($l['native_name'], $l['translated_name']);
            if(!$l['active']) echo '</a>';
            echo '</li>';
        }
        echo '</ul></div>';
    }
}
}

if ( ! function_exists( 'bit4bytes_is_woocommerce_activated' ) ) {
	/**
	 * Query WooCommerce activation
	 */
	function bit4bytes_is_woocommerce_activated() {
		return class_exists( 'WooCommerce' ) ? true : false;
	}
}


if ( ! function_exists( 'bit4bytes_cart_link' ) ) {
	/**
	 * Cart Link
	 * Displayed a link to the cart including the number of items present and the cart total
	 *
	 * @return void
	 * @since  1.0.0
	 */
	function bit4bytes_cart_link() {
		?>
		<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" id="cart" title="Cart">
		<i class="fa fa-shopping-cart"></i> 
        <span class="cart__contents">
            (
			<?php echo WC()->cart->get_cart_contents_count();?>
			)
        </span>
        
        
        </a>
        
		
		<?php
	}
}

/** Mini-Cart 
 * 
 * 	<a class="cart-contents"  style="display:none;" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'storefront' ); ?>">
				<span class="amount">
                   <?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?>
                </span> 
                <span class="count">
                  <?php echo wp_kses_data( sprintf( 
                                           _n( '%d item', '%d items', WC()->cart->get_cart_contents_count()
                                           , 'storefront' 
                                         )
                      , WC()->cart->get_cart_contents_count() ) );?>
                </span>
			</a>
 * 
*/

if ( ! function_exists( 'bit4bytes_woocommerce_mini_cart' ) ) {

    /**
     * Output the Mini-cart - used by cart widget.
     *
     * @param array $args Arguments.
     */
    function bit4bytes_woocommerce_mini_cart( $args = array() ) {

        $defaults = array(
            'list_class' => '',
        );

        $args = wp_parse_args( $args, $defaults );

        //wc_get_template( 'woocommerce/cart/mini-cart.php', $args );
    }
}

if ( ! function_exists( 'bit4bytes_header_cart' ) ) {
	/**
	 * Display Header Cart
	 *
	 * @since  1.0.0
	 * @uses  storefront_is_woocommerce_activated() check if WooCommerce is activated
	 * @return void
	 */
	function bit4bytes_header_cart() {
		if ( bit4bytes_is_woocommerce_activated() ) {
			if ( is_cart() ) {
				$class = 'current-menu-item';
			} else {
				$class = '';
			}

		
		?>        
         
		<ul id="site-header-cart" class="navigation__secondary navigation__list navigation__list--left">
		
		<li class="navigation__item"><a href="" class="navigation__link">EN</a></li>
          <li class="navigation__item"><a href="" class="navigation__link"> <i class="fas fa-search"></i></a></li>
          <li class="navigation__item"><a href="/my-account" class="navigation__link"> <i class="fas fa-user"></i></a></li>
			<li class="<?php echo esc_attr( $class ); ?> navigation__item">
				<?php bit4bytes_cart_link(); ?>
			</li>
			<li style="display:none;">
                <?php bit4bytes_woocommerce_mini_cart(); ?>
			</li>
		</ul>
		<?php
		}
	}
}

class Footer_Walker_Nav_Menu extends Walker_Nav_Menu {
	function start_el ( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
	  // Copy all the start_el code from source, and modify
	 
        $output .= sprintf( "\n<li class=\"footer-nav__item\"><a class=\"footer-nav__link\" href='%s'%s>%s</a></li>\n",
            $item->url,
            ( $item->object_id === get_the_ID() ) ? ' class="current"' : '',
            $item->title
        );
    
	}
  
	function end_el( &$output, $item, $depth = 0, $args = array() ) {
	  // Copy all the end_el code from source, and modify
	}
  }


class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
	function start_el ( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
	  // Copy all the start_el code from source, and modify
	 
        $output .= sprintf( "\n<li class=\"navigation__item\"><a class=\"navigation__link\" href='%s'%s>%s</a></li>\n",
            $item->url,
            ( $item->object_id === get_the_ID() ) ? ' class="current"' : '',
            $item->title
        );
    
	}
  
	function end_el( &$output, $item, $depth = 0, $args = array() ) {
	  // Copy all the end_el code from source, and modify
	}
  }

  function FOOBAR_get_custom_logo( $blog_id = 0 ) {
    $html = '';

    if ( is_multisite() && (int) $blog_id !== get_current_blog_id() ) {
        switch_to_blog( $blog_id );
    }

    $custom_logo_id = get_theme_mod( 'custom_logo' );

    if ( $custom_logo_id ) {
        $html = sprintf( '<a href="%1$s" class="custom-logo-link" rel="home" itemprop="url">%2$s</a>',
            esc_url( home_url( '/' ) ),
            wp_get_attachment_image( $custom_logo_id, 'full', false, array(
                'class'    => 'custom-logo FOO-BAR FOO BAR', // added classes here
                'itemprop' => 'logo',
            ) )
        );
    }

    elseif ( is_customize_preview() ) {
        $html = sprintf( '<a href="%1$s" class="custom-logo-link" style="display:none;"><img class="custom-logo"/></a>',
            esc_url( home_url( '/' ) )
        );
    }

    if ( is_multisite() && ms_is_switched() ) {
        restore_current_blog();
    }

    return apply_filters( 'FOOBAR_get_custom_logo', $html );
}


if ( ! function_exists( 'kimnaturav1_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function kimnaturav1_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on kimnaturaV1, use a find and replace
		 * to change 'kimnaturav1' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'kimnaturav1', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );


		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 1200, 9999 );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'kimnaturav1' ),
			'footer-1' => esc_html__( 'Footer 1', 'kimnaturav1' ),
			'footer-2' => esc_html__( 'Footer 2', 'kimnaturav1' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'kimnaturav1_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'kimnaturav1_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function kimnaturav1_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'kimnaturav1_content_width', 640 );
}
add_action( 'after_setup_theme', 'kimnaturav1_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function kimnaturav1_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'kimnaturav1' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'kimnaturav1' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'kimnaturav1_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function kimnaturav1_scripts() {

	wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', array(), null, true);
	wp_enqueue_style( 'kimnaturav1-style', get_stylesheet_uri() );

	wp_enqueue_script( 'kimnaturav1-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'kimnaturav1-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if (is_shop()){
		wp_enqueue_script( 'kimnaturav1-collapse', get_template_directory_uri() . '/js/app.js', array(), '20151215', true );
	} 
}
add_action( 'wp_enqueue_scripts', 'kimnaturav1_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

require get_template_directory() . '/inc/metabox.php';


require get_template_directory() . '/widgets/b4bProductCategoriesFilter.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}


/**
 * Homepage
 */
require get_template_directory() . '/inc/homepage.php';


if ( class_exists( 'Subtitles' ) && method_exists( 'Subtitles', 'subtitle_styling' ) ) {
	remove_action( 'wp_head', array( Subtitles::getInstance(), 'subtitle_styling' ) );
}
add_filter('subtitle_view_supported', '__return_false');



function custom_page_template( $page_template ) {
	//if (is_home()) {
	  $page_template = plugin_dir_path( __FILE__ ) . 'page-my.php';
	  return $page_template;
	//}
  }
  //add_filter( 'template_include', 'custom_page_template' );
  // Remove each style one by one

//add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );



function my_custom_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'Shop', 'your-theme-domain' ),
            'id' => 'woocommerce-shop',
            'description' => __( 'Custom Sidebar', 'your-theme-domain' ),
            'before_widget' => '',
            'after_widget' => "",
            'before_title' => '<h4>',
            'after_title' => '</h4>',
        )
    );
}
add_action( 'widgets_init', 'my_custom_sidebar' );

// define the woocommerce_sidebar callback 
function action_woocommerce_sidebar( ) { 
	// make action magic happen here... 
	dynamic_sidebar('woocommerce-shop');
}; 
         
// add the action 
//add_action( 'woocommerce_sidebar', 'action_woocommerce_sidebar', 10, 2 ); 


// Add language switcher
if ( ! function_exists( 'b4b_languages_list' ) ) {
	function b4b_languages_list(){
		$languages = icl_get_languages('skip_missing=0&orderby=code');
		if(!empty($languages)){
			echo '<div id="language_list"><ul>';
			foreach($languages as $l){
				echo '<li>';
				if($l['country_flag_url']){
					if(!$l['active']) echo '<a href="'.$l['url'].'">';
					echo '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" />';
					if(!$l['active']) echo '</a>';
				}
				if(!$l['active']) echo '<a href="'.$l['url'].'">';
				echo icl_disp_language($l['native_name'], $l['translated_name']);
				if(!$l['active']) echo '</a>';
				echo '</li>';
			}
			echo '</ul></div>';
		}
	}
}


// Add language switcher
add_action('b4b_single_post_after_content', 'b4b_blog_post_woocommerce_related_products');
//if ( ! function_exists( 'b4b_blog_post_woocommerce_related_products' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function b4b_blog_post_woocommerce_related_products() {
		global $post;
		$productIDs = get_post_meta($post->ID,'custom_productIds',true);
		//var_dump($productIDs);
		//var_dump($post->ID);
		if ($productIDs == ''){
			$productIDs = array(0);
		}
        $args = array(
            'post_type' => 'product',
			'post__in' => $productIDs
        );
		$loop = new WP_Query( $args );

		if ( $loop->have_posts() ):
		?>

		<section class="section section--fluid page__related-products">
        <div class="products__most-selling">
		<h2 class="products__title products__title--center"><?php echo  __('Povezani proizvodi')?></h2>
		<div class="products__slider-wrapper">
	       <div class="owl-carousel owl-theme products__slider">
	    <?php
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
        </a>
			
		</div>
		<?php endwhile; 
		endif;
		
		?>
			</div>
		</div>
	
		</div>
		</section>
		<?php wp_reset_query(); 

		
	}
//endif;


	



// Copyright date
function b4b_copyright() {
	global $wpdb;
	$copyright_dates = $wpdb->get_results("
	SELECT
	YEAR(min(post_date_gmt)) AS firstdate,
	YEAR(max(post_date_gmt)) AS lastdate
	FROM
	$wpdb->posts
	WHERE
	post_status = 'publish'
	");
	$output = '';
	if($copyright_dates) {
	$copyright = "© " . $copyright_dates[0]->firstdate;
	if($copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate) {
	$copyright .= '-' . $copyright_dates[0]->lastdate;
	}
	$output = $copyright;
	}
	return $output;
}


// Optimizator
function wpb_remove_version() {
	return '';
}
add_filter('the_generator', 'wpb_remove_version');


function my_enqueue_stuff() {
	global $B4BWP;
	if ( is_single() && 'post' == get_post_type() ) {
		
	  }
	//  var_dump( get_post_type());
	if ( is_page( 'single' ) || is_single()||is_singular('post')) {
		$B4BWP->setScripts(b4b_adding_js('carousel','/js/blog.js')); 
	} else {
	  /** Call regular enqueue */

	  $B4BWP->setScripts(b4b_adding_js('carousel','/js/blog.js')); 
	}
  }
  my_enqueue_stuff();
 // add_action( 'wp_enqueue_scripts', 'my_enqueue_stuff' );
$B4BWP->doScripts();


