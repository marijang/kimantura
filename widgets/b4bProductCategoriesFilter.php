<?php
/*
Plugin Name: B4B Products by category
Description: This plugin displays a list of products of a certain category on your website.
*/


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class b4bProductCategories_widget extends WP_Widget {
    // Set up the widget name and description.

    protected $scripts = array();

    public function __construct() {
        $widget_options = array( 
            'classname' => 'b4bProductCategories_widget', 
            'description' => 'Custom B4b Woocommerce Category Widget' 
            );
        parent::__construct( 'b4bProductCategories_widget', 'B4B Product Categories Widget', $widget_options );
        wp_enqueue_script(
            'b4bProductCategories',
            get_template_directory_uri(). '/js/b4bProductCategories.js',
            array(),
            false,
            true
        );
        $this->scripts['b4bProductCategories_widget'] = false;
        add_action( 'wp_print_footer_scripts', array( &$this, 'remove_scripts' ) );
    }
    
    // Create the widget output.
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance[ 'title' ] );

        $this->scripts['b4bProductCategories_widget'] = true;
    
        // before and after widget arguments are defined by themes
        //$blog_title = get_bloginfo( 'name' );
        //$tagline = get_bloginfo( 'description' );
        echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title']; 


        global $wp_query;
     //var_dump( $wp_query);
        // Custom Woo Category Output
        $taxonomy     = 'product_cat';
      //  $orderby      = 'menu_order';  
      $orderby      = 'name';  
        $order        = 'ASC';
        $show_count   = 0;      // 1 for yes, 0 for no
        $pad_counts   = 0;      // 1 for yes, 0 for no
        $hierarchical = 1;      // 1 for yes, 0 for no  
        $title        = '';  
        $hide_empty = false;
        $empty        = 0;

        $product_args = array(
          //  'taxonomy'     => $taxonomy,
            'orderby'      => $orderby,
            'show_count'   => $show_count,
            'pad_counts'   => $pad_counts,
            'hierarchical' => $hierarchical,
            'title_li'     => $title,
            'hide_empty'   => $empty,
            'parent'        => 0
        );
      

        $product_categories = get_terms( 'product_cat', $product_args );

        $count = count( $product_categories );
        if ( $count > 0 ) {
            $categories = array();
            if (!empty($_GET['category'])) {
                $categories = explode(',',$_GET['category']);
                echo '<input name="product_cat" type="hidden" value="'.esc_attr($_GET['category']).'">';
            }else{
                echo '<input name="product_cat" type="hidden" value="" data-parent="autmn">';
            }
        echo '<ul class="shop-categories__list">';

        foreach ( $product_categories as $cat ) {
            $active_cat = $cat->name == single_cat_title( '', false ) ? ' is-active' : '';
            $terms = get_term_children( $cat->term_id,  $taxonomy );
            $checked = in_array($cat->slug,$categories) ? 'checked':'';
            echo '
            <li class="shop-categories__item' . $active_cat . '">' .
                
                '<label href1="' . esc_url( get_term_link( $cat ) ) . '" data-term="'.$cat->id.'">'.
                '<input name="product_cat[]" type="checkbox" value="'.$cat->slug.'" '.$checked.'>'.
                '<span class="shop-categories__title">' . esc_html( $cat->name ) . '</span>';
                if(!empty($terms) ) {
                echo '<i class="mi shop-categories__icon">keyboard_arrow_up</i>';
                }
            echo '</label>' ;
            
            if(!empty($terms) ) {
                $category_id = $cat->term_id;       
                echo '<ul class="shop-categories__childs">';
                $args2 = array(
                        'taxonomy'     => $taxonomy,
                        'child_of'     => 0,
                        'parent'       => $category_id,
                        'orderby'      => $orderby,
                        'show_count'   => $show_count,
                        'pad_counts'   => $pad_counts,
                        'hierarchical' => $hierarchical,
                        'title_li'     => $title,
                        'hide_empty'   => $hide_empty
                );
                $sub_cats = get_terms( 'product_cat',$args2); //get_categories( $args2 );
                if($sub_cats) {
                    foreach($sub_cats as $sub_category) {
                        $active_cat_S = $sub_category->name == single_cat_title( '', false ) ? ' is-active' : '';
                        $checked = in_array($sub_category->slug,$categories) ? 'checked':'';
                        echo '
                        <label class="shop-categories__item' . $active_cat_S . '">' .
                        '<input name="product_cat[]" type="checkbox"  value="'.$sub_category->slug.'" '.$checked.'>'.
                            '<span href1="' . esc_url( get_term_link( $sub_category ) ) . '">' .
                           
                            '<span class="shop-categories__title">' . esc_html( $sub_category->name ) . '</span>' .
                            ' <span class="shop-categories__count">' . $sub_category->count . '</span>'.
                            '</span>
                        </label>' ;
                    }   
                }
                echo '</ul>';
            }       


            echo '</li>';
           
        }

        echo '</ul>
        <button class="btn btn--primary .testajax">Test Ajax<button>
        ';
        }
    
        echo $args['after_widget'];
    }
    public function remove_scripts()
    {
        foreach ( $this->scripts as $script => $keep ) {
            if ( ! $keep ) {
                // It seems dequeue is not "powerful" enough, you really need to deregister it
                wp_deregister_script( $script );
            }
        }
    }
    // Create the admin area widget settings form.
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : ''; ?>    
        <p>
          <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
          <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
        </p><?php
    }
    
    // Apply settings to the widget instance.
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
        return $instance;
      }
    }
    
// Register the widget.
function b4bProductCategories_widget() { 
register_widget( 'b4bProductCategories_widget' );
}
add_action( 'widgets_init', 'b4bProductCategories_widget' );
